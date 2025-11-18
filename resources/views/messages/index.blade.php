<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($messages->isEmpty())
                        <p class="text-gray-500">No approved messages yet.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($messages as $message)
                                <div class="border-b pb-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-lg">{{ $message->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $message->email }}</p>
                                            <p class="text-sm text-gray-500">Post: {{ $message->post->title }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-2 text-gray-700">{{ $message->message }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $messages->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
