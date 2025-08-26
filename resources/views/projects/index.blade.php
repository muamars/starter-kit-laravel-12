@extends('layouts.app')

@section('title', 'Projects')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Projects</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your projects</p>
        </div>
        @can('create projects')
        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Project
        </a>
        @endcan
    </div>

    <!-- Projects List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($projects->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($projects as $project)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-green-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($project->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $project->name }}
                                </p>
                                @if($project->status === 'planning')
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Planning
                                    </span>
                                @elseif($project->status === 'in_progress')
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <p>By {{ $project->user->name }}</p>
                                <span class="mx-1">•</span>
                                <p>{{ $project->created_at->format('M d, Y') }}</p>
                                @if($project->start_date)
                                    <span class="mx-1">•</span>
                                    <p>Starts {{ $project->start_date->format('M d, Y') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View
                        </a>
                        @can('edit projects')
                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Edit
                        </a>
                        @endcan
                        @can('delete projects')
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No projects</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
            @can('create projects')
            <div class="mt-6">
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Project
                </a>
            </div>
            @endcan
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($projects->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
