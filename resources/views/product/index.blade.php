@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1>{{ __('Products') }}</h1>
                <a href="{{ route('admin.product.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Add Product') }}
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.product.store') }}" method="POST" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search Products..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> {{ __('Search') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header">{{ __('Products List') }}</div>

                <div class="card-body">
                    @if ($products->isEmpty())
                        <p>{{ __('No products found.') }}</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Brand') }}</th>
                                    <th>{{ __('SKU') }}</th>
                                    <th>{{ __('Stock') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ Storage::url('public/product/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                            @else
                                                {{ __('No Image') }}
                                            @endif
                                        </td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ number_format($product->price, 2) }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ optional($product->brand)->name ?? 'N/A' }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete {{$product->name}}?')">
                                                    <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
