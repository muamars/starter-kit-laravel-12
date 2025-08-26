@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Users Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage system users and their roles</p>
        </div>
        @can('create users')
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New User
        </a>
        @endcan
    </div>

    <!-- Users List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($users->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($users as $user)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $user->name }}
                                </p>
                                @foreach($user->roles as $role)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <p>{{ $user->email }}</p>
                                <span class="mx-1">•</span>
                                <p>Joined {{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View
                        </a>
                        @can('edit users')
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Edit
                        </a>
                        @endcan
                        @can('delete users')
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                Delete
                            </button>
                        </form>
                        @endif
                        @endcan
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No users</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
