@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>{{ __('Brand') }}</h1>
                <a href="{{ route('admin.brand.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Add Brand') }}
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.brand.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Brands..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Brands Table -->
            <div class="card">
                <div class="card-header">{{ __('Brand List') }}</div>

                <div class="card-body">
                    @if ($brands->isEmpty())
                        <p>{{ __('No brand found.') }}</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Slug') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Updated At') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $brand->id }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>
                                            @if ($brand->image)
                                                <img src="{{ Storage::url('brands/' . $brand->image) }}" alt="{{ $brand->name }}" width="100" height="50">
                                            @else
                                                {{ __('No Image') }}
                                            @endif
                                        </td>
                                        <td>{{ $brand->created_at }}</td>
                                        <td>{{ $brand->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.brand.edit', $brand->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete {{$brand->name}} brand?')">
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
                            {{ $brands->links('pagination.custom-pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
