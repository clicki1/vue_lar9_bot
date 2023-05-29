<ul class="list-group mb-3">
    <li class="list-group-item py-3 list-group-item-secondary">Категории</li>
    @foreach($categories as $category)
        <li class="list-group-item list-group-item-action py-3 lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <strong class="mb-1">{{ $category->title }}</strong>
                <a href="{{route('categories.edit', $category->id)}}">
                    <button class="btn btn-success btn-sm">Изменить</button>
                </a>
                <form action="{{route('categories.destroy', $category->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Удалить</button>
                </form>
            </div>
        </li>
    @endforeach
        <li class="list-group-item list-group-item-action  lh-sm" aria-current="true">
            {{ $categories->links() }}
        </li>
</ul>
