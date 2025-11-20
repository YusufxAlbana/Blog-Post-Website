<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:bug,suggestion',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create report
        $report = Report::create([
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Send message to all admins
        $admins = User::where('role', 'admin')->get();
        
        $icon = $validated['type'] === 'bug' ? '🐛' : '💡';
        $typeLabel = $validated['type'] === 'bug' ? 'Bug Report' : 'Suggestion';
        
        foreach ($admins as $admin) {
            Message::create([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'message' => "{$icon} {$typeLabel}: {$validated['title']}\n\n{$validated['description']}\n\n--- Submitted by: " . Auth::user()->name . " (" . Auth::user()->email . ")",
                'post_id' => null, // No post associated
                'user_id' => $admin->id,
                'is_approved' => true, // Auto-approve reports
            ]);
        }

        $successMessage = $validated['type'] === 'bug' 
            ? 'Bug report submitted successfully! All admins have been notified.'
            : 'Suggestion submitted successfully! All admins have been notified.';

        return redirect()->route('reports.index')->with('success', $successMessage);
    }
}
