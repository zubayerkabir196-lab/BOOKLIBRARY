@extends('layout1')
@section('page-title','Create Category')
@section('Page-subtitle','Add a new category to the collection')
@section('content')
<div class="flex-1 p-6 lg:p-8">
        <div class="max-w-2xl">
          <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-gradient-tor from-indigo-500 to-purple-600 h-2"></div>
            <form class="p-6 space-y-6" action="{{route('categories.store')}}" method="POST">
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
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name <span class="text-red-500">*</span></label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                  placeholder="Enter category name"
                />
              </div>

              <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea
                  id="description"
                  name="description"
                  rows="4"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none"
                  placeholder="Enter category description"
                ></textarea>
              </div>
              
               <div>
                <label for="books_count" class="block text-sm font-medium text-gray-700 mb-2">
                  Books Count 
                </label>
                <input
                  type="number"
                  id="books_count"
                  name="books_count"
                  min="0"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                  placeholder="Enter number of books"
                />
              </div>

              <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select
                  id="status"
                  name="status"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>

              <div class="flex items-center justify-end space-x-4 pt-4">
                <a
                  href="./category-list.html"
                  class="px-6 py-3 border border-gray-300 rounded-lg text-gray-600 hover:text-gray-800 hover:border-gray-400 transition-all duration-200"
                >
                  Cancel
                </a>
                <button
                  type="submit"
                  class="px-6 py-3 bg-gradient-tor from-indigo-600 to-purple-600 text-black rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-md"
                >
                  Create Category
                </button>
              </div>
            </form>
          </div>
        </div>
      </main>
    </div>
@endsection