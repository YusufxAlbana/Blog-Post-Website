<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $groups = auth()->user()->groups()
            ->with(['latestMessage.user', 'members'])
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest('updated_at')
            ->get();
        
        return view('groups.index', compact('groups', 'search'));
    }

    public function create()
    {
        // Get mutual followers (users who follow me AND I follow them)
        $mutualFollowers = auth()->user()->mutualFollowers()->get();
        
        return view('groups.create', compact('mutualFollowers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:users,id'
        ]);

        // Verify all members are mutual followers
        $mutualFollowerIds = auth()->user()->mutualFollowers()->pluck('users.id')->toArray();
        foreach ($request->members as $memberId) {
            if (!in_array($memberId, $mutualFollowerIds)) {
                return back()->withErrors(['members' => 'You can only add mutual followers to the group.']);
            }
        }

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id()
        ]);

        // Add creator as admin
        $group->members()->attach(auth()->id(), ['is_admin' => true]);

        // Add selected members
        foreach ($request->members as $memberId) {
            $group->members()->attach($memberId, ['is_admin' => false]);
        }

        return redirect()->route('groups.show', $group)->with('success', 'Group created successfully!');
    }

    public function show(Group $group)
    {
        // Check if user is a member
        if (!$group->isMember(auth()->id())) {
            abort(403, 'You are not a member of this group.');
        }

        $messages = $group->messages()
            ->with('user')
            ->latest()
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return view('groups.show', compact('group', 'messages'));
    }

    public function sendMessage(Request $request, Group $group)
    {
        // Check if user is a member
        if (!$group->isMember(auth()->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        $message = GroupMessage::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        $group->touch(); // Update group's updated_at

        return response()->json([
            'success' => true,
            'message' => $message->load('user')
        ]);
    }

    public function addMembers(Request $request, Group $group)
    {
        // Check if user is admin
        if (!$group->isAdmin(auth()->id())) {
            return back()->withErrors(['error' => 'Only admins can add members.']);
        }

        $request->validate([
            'members' => 'required|array|min:1',
            'members.*' => 'exists:users,id'
        ]);

        // Verify all members are mutual followers
        $mutualFollowerIds = auth()->user()->mutualFollowers()->pluck('users.id')->toArray();
        
        foreach ($request->members as $memberId) {
            if (!in_array($memberId, $mutualFollowerIds)) {
                return back()->withErrors(['members' => 'You can only add mutual followers to the group.']);
            }
            
            // Add member if not already in group
            if (!$group->isMember($memberId)) {
                $group->members()->attach($memberId, ['is_admin' => false]);
            }
        }

        return back()->with('success', 'Members added successfully!');
    }

    public function searchMembers(Request $request, Group $group)
    {
        $search = $request->input('search');
        
        // Get mutual followers who are not already in the group
        $existingMemberIds = $group->members()->pluck('users.id')->toArray();
        
        $availableUsers = auth()->user()->mutualFollowers()
            ->whereNotIn('users.id', $existingMemberIds)
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        return response()->json($availableUsers);
    }
}
