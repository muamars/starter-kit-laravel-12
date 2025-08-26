@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <div class="flex items-center space-x-3">
                <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
                @if($project->status === 'planning')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Planning
                    </span>
                @elseif($project->status === 'in_progress')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        In Progress
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Completed
                    </span>
                @endif
            </div>
            <div class="mt-2 flex items-center text-sm text-gray-500">
                <p>By {{ $project->user->name }}</p>
                <span class="mx-1">•</span>
                <p>{{ $project->created_at->format('M d, Y \a\t g:i A') }}</p>
                @if($project->updated_at != $project->created_at)
                    <span class="mx-1">•</span>
                    <p>Updated {{ $project->updated_at->format('M d, Y \a\t g:i A') }}</p>
                @endif
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Projects
            </a>
            @can('edit projects')
            <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            @endcan
            @can('delete projects')
            <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </form>
            @endcan
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-8">
            <div class="prose max-w-none">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                <p class="text-gray-700 whitespace-pre-line">{{ $project->description }}</p>
            </div>
        </div>
    </div>

    <!-- Project Information -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Project Information</h3>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @if($project->status === 'planning')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Planning
                            </span>
                        @elseif($project->status === 'in_progress')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Project Manager</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->start_date ? $project->start_date->format('F d, Y') : 'Not set' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">End Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $project->end_date ? $project->end_date->format('F d, Y') : 'Not set' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('F d, Y \a\t g:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $project->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
