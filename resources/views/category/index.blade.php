@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>{{ __('Category') }}</h1>
                <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Add Category') }}
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.category.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Category..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Categories Table -->
            <div class="card">
                <div class="card-header">{{ __('Category List') }}</div>

                <div class="card-body">
                    @if ($categories->isEmpty())
                        <p>{{ __('No category found.') }}</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Parent Category') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            @if ($category->image)
                                                <img src="{{ Storage::url('public/categories/' . $category->image) }}" alt="{{ $category->name }}" width="100" height="50">
                                            @else
                                                {{ __('No Image') }}
                                            @endif
                                        </td>
                                        <td>{{ $category->parentCategory ? $category->parentCategory->name : __('None') }}</td>
                                        <td>
                                            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete {{$category->name}} category?')">
                                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $categories->links('pagination.custom-pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
