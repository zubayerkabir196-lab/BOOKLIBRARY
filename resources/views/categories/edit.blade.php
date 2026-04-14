@extends('layout1')
@section('page-title','Edit Category')
@section('add-link',route('categories.edit',$category->id))
@section('page-subtitle','Edit category to the collection')
@section('content')
    <!-- Content -->
    <div class="flex-1 p-6 lg:p-8">
  <div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow overflow-hidden">
      <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2"></div>
      <form class="p-6 space-y-6" action="{{ route('categories.update',$category->id) }}" method="POST">
        @csrf
        <!-- Name -->
        @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
             category Name <span class="text-red-500">*</span>
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name',$category->name) }}"
            required
            minlength="2"
            maxlength="255"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
            placeholder="Enter author name"
          />
        </div>

        <!-- description -->
        <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
        </label>
        <textarea
            id="description"
            name="description"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
            placeholder="Enter category description"
        >{{ old('description', $category->description) }}</textarea>
        </div>

        <!-- Books Count -->
        <div>
          <label for="books_count" class="block text-sm font-medium text-gray-700 mb-2">
            Books Count 
          </label>
          <input
            type="number"
            id="books_count"
            name="books_count"
            value="{{ old('books_count',$category->books_count) }}"
            required
            min="0"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
            placeholder="Enter number of books"
          />
        </div>

        <!-- Status -->
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
            Status 
          </label>
          <select
            id="status"
            name="status"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
          >
            <option value="active" @selected(old('status',$category->status)==='active')>Active</option>
            <option value="inactive" @selected(old('status',$category->status)==='inactive')>Inactive</option>
          </select>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4">
          <a
            href="{{ route('categories.index') }}"
            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-all duration-200"
          >
            Cancel
          </a>
          <button
          <a href = "{{ route('categories.update', ['category' => $category->id]) }}"
            type="submit"
            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md"
          >
            Update Category
            </a>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection