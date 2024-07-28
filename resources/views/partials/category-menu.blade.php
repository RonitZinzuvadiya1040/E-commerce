@foreach ($categories as $category)
    @if ($category->children->isEmpty())
        <li class="nav-item">
            <a class="nav-link" href="#">{{ $category->name }}</a>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $category->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $category->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $category->id }}">
                @include('partials.category-menu', ['categories' => $category->children])
            </div>
        </li>
    @endif
@endforeach
