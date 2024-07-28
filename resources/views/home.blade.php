@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row">
        <!-- Sidebar with Categories -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4>Categories</h4>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('category.products', $category->id) }}">
                                {{ $category->name }}
                                @if($category->children->isNotEmpty())
                                    <span class="toggle-arrow float-right">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </a>
                            @if(isset($selectedCategory) && $selectedCategory->id == $category->id)
                                @include('partials.subcategories', ['subcategories' => $category->children])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Main Content with Products -->
        <div class="col-md-9">
            @isset($selectedCategory)
                <h2 class="mb-4">{{ $selectedCategory->name }}</h2>
            @else
                <h2 class="mb-4">All Products</h2>
            @endisset

            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/product/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text">{{ $product->price }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p>No products available in this category.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleArrows = document.querySelectorAll('.toggle-arrow');
        toggleArrows.forEach(function(arrow) {
            arrow.addEventListener('click', function(event) {
                event.preventDefault();
                const subcategories = arrow.closest('li').querySelector('ul');
                if (subcategories) {
                    subcategories.classList.toggle('d-none');
                    arrow.querySelector('i').classList.toggle('fa-chevron-down');
                    arrow.querySelector('i').classList.toggle('fa-chevron-right');
                }
            });
        });
    });
</script>
@endsection
