@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create New Role</h1>
            <p class="mt-1 text-sm text-gray-600">Define a new role with permissions</p>
        </div>
        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Roles
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.roles.store') }}" class="space-y-6 p-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                <div class="mt-1">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           placeholder="Enter role name">
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Permissions</label>
                <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @php
                        $groupedPermissions = $permissions->groupBy(function($permission) {
                            return explode(' ', $permission->name)[1] ?? 'other';
                        });
                    @endphp

                    @foreach($groupedPermissions as $group => $groupPermissions)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3 capitalize">{{ $group }} Permissions</h4>
                        <div class="space-y-2">
                            @foreach($groupPermissions as $permission)
                            <div class="flex items-center">
                                <input type="checkbox" name="permissions[]" id="permission_{{ $permission->id }}" value="{{ $permission->name }}"
                                       {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="permission_{{ $permission->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @error('permissions')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.roles.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
