@extends('layouts.app')

@section('title', $role->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">{{ $role->name }} Role</h1>
            <div class="mt-2 flex items-center text-sm text-gray-500">
                <p>{{ $role->permissions->count() }} permissions</p>
                <span class="mx-1">•</span>
                <p>{{ $role->users->count() }} users assigned</p>
                <span class="mx-1">•</span>
                <p>Created {{ $role->created_at->format('M d, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Roles
            </a>
            @can('edit roles')
            <a href="{{ route('admin.roles.edit', $role) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            @endcan
        </div>
    </div>

    <!-- Permissions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions</h3>
            @if($role->permissions->count() > 0)
                @php
                    $groupedPermissions = $role->permissions->groupBy(function($permission) {
                        return explode(' ', $permission->name)[1] ?? 'other';
                    });
                @endphp

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($groupedPermissions as $group => $groupPermissions)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3 capitalize">{{ $group }} Permissions</h4>
                        <div class="space-y-2">
                            @foreach($groupPermissions as $permission)
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-900">{{ $permission->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No permissions assigned to this role.</p>
            @endif
        </div>
    </div>

    <!-- Users with this role -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Users with this Role</h3>
            @if($role->users->count() > 0)
                <div class="space-y-3">
                    @foreach($role->users as $user)
                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center">
                                <span class="text-xs font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        @can('view users')
                        <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View User
                        </a>
                        @endcan
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No users assigned to this role.</p>
            @endif
        </div>
    </div>

    <!-- Role Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Role Information</h3>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Role Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $role->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Guard Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $role->guard_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $role->created_at->format('F d, Y \a\t g:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $role->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
