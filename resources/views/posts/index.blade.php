<!-- resources/views/posts/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Create New Post</a>
                    </div>

                    <table class="min-w-full bg-white dark:bg-gray-700">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">#</th>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Category</th>
                            <th class="py-2 px-4 border-b">Author</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($posts as $post)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b">{{ $post->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $post->category ? $post->category->name : 'Uncategorized' }}</td>
                                <td class="py-2 px-4 border-b">{{ $post->user ? $post->user->name : 'Unknown' }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">View</a>
                                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 px-4 border-b text-center text-gray-600 dark:text-gray-300">No posts available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
