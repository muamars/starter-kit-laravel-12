@extends('layouts.app')

@section('title', 'Blogs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Blogs</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your blog posts</p>
        </div>
        @can('create blogs')
        <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Blog
        </a>
        @endcan
    </div>

    <!-- Blogs List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($blogs->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($blogs as $blog)
            <li>
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($blog->title, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="flex items-center">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $blog->title }}
                                </p>
                                @if($blog->is_published)
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Published
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Draft
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <p>By {{ $blog->user->name }}</p>
                                <span class="mx-1">•</span>
                                <p>{{ $blog->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('blogs.show', $blog) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View
                        </a>
                        @can('edit blogs')
                        <a href="{{ route('blogs.edit', $blog) }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                            Edit
                        </a>
                        @endcan
                        @can('delete blogs')
                        <form method="POST" action="{{ route('blogs.destroy', $blog) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog?')">
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No blogs</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog post.</p>
            @can('create blogs')
            <div class="mt-6">
                <a href="{{ route('blogs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Blog
                </a>
            </div>
            @endcan
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($blogs->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        {{ $blogs->links() }}
    </div>
    @endif
</div>
@endsection
