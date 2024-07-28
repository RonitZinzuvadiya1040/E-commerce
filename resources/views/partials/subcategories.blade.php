<ul class="list-group list-group-flush ml-3">
    @foreach($subcategories as $subcategory)
        <li class="list-group-item">
            <a href="{{ route('category.products', $subcategory->id) }}">{{ $subcategory->name }}</a>
            @if($subcategory->children->isNotEmpty())
                @include('partials.subcategories', ['subcategories' => $subcategory->children])
            @endif
        </li>
    @endforeach
</ul>
