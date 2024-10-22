<!-- resources/views/category/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded">Create New Category</a>
                    </div>

                    <table class="min-w-full bg-white dark:bg-gray-700">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">#</th>
                            <th class="py-2 px-4 border-b">Name</th>
                            <th class="py-2 px-4 border-b">Slug</th>
                            <th class="py-2 px-4 border-b">Parent Category</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                                <td class="py-2 px-4 border-b">{{ $category->slug }}</td>
                                <td class="py-2 px-4 border-b">
                                    {{ $category->parent ? $category->parent->name : 'N/A' }}
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 px-4 border-b text-center text-gray-600 dark:text-gray-300">No categories available.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
