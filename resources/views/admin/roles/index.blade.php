@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Roles Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage system roles and permissions</p>
        </div>
        @can('create roles')
        <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Role
        </a>
        @endcan
    </div>

    <!-- Roles List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($roles->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($roles as $role)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-yellow-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($role->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $role->name }}
                                </p>
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $role->permissions->count() }} permissions
                                </span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <p>{{ $role->users->count() }} users assigned</p>
                                <span class="mx-1">•</span>
                                <p>Created {{ $role->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.roles.show', $role) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View
                        </a>
                        @can('edit roles')
                        <a href="{{ route('admin.roles.edit', $role) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Edit
                        </a>
                        @endcan
                        @can('delete roles')
                        @if(!in_array($role->name, ['Admin', 'Writer', 'Manager']))
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No roles</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new role.</p>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        {{ $roles->links() }}
    </div>
    @endif
</div>
@endsection
