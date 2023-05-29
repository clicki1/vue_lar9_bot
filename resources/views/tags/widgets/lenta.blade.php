<ul class="list-group mb-3">
    <li class="list-group-item py-3 list-group-item-secondary"> Тэги</li>
    @foreach($tags as $tag)
        <li class="list-group-item list-group-item-action  lh-sm" aria-current="true">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <h5 class="mb-1">{{ $tag->category->title }}</h5>
                <small class="text-muted"> - категория | тэг -</small>
                <strong class="mb-1">{{ $tag->title }}</strong>
                <div class="btn-group">
                    <a href="{{route('tags.edit', $tag->id)}}">
                        <button class="btn btn-success btn-sm">Изменить</button>
                    </a>
                    <form action="{{route('tags.destroy', $tag->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Удалить</button>
                    </form>
                </div>


            </div>
        </li>
    @endforeach
   <li class="list-group-item list-group-item-action  lh-sm" aria-current="true">
       {{ $tags->withQueryString()->links() }}
   </li>
</ul>


