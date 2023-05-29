

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Итоговая таблица</h3>
    </div>
    @if(isset($data) && empty(array_filter($data)))
@include('result.widgets.resfilterAll')
    @endif
</div>
<ul class="list-group mb-3">
    <li class="list-group-item py-3 list-group-item-secondary">Результаты</li>
    @foreach($results as $result)
        <li class="list-group-item" aria-current="true">
            <div class="d-flex align-items-center justify-content-between">
                <strong class="ml-2">{{ $result->coast }}</strong>
                <span
                    class="text-muted m-1">{{ isset($result->category_id) ? $result->category->title : 'Нет категории' }}</span>
                <span class="text-muted">{{ $result->message->message }} </span>
                <form class="card ml-2" action="{{ route('results.update', $result->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="input-group input-group-sm">

                        @if($result->category_id)
                            <select class="form-select form-select-sm" name="category_id">
                                @foreach($categories as $catedory)
                                    <option value="{{$catedory->id}}"
                                        {{ $result->category_id === $catedory->id  ? 'selected' : '' }}
                                    >{{ $catedory->title }}</option>
                                @endforeach

                                @else
                                    <select class="form-select form-select-sm text-bg-secondary" name="category_id">
                                        <option class="bg-danger" selected>Выберите категорию</option>
                                        @foreach($categories as $catedory)
                                            <option value="{{$catedory->id}}">{{ $catedory->title }}</option>
                                        @endforeach

                                        @endif

                                    </select>
                                    <button type="submit" class="btn btn-outline-secondary"><i
                                            class="bi bi-arrow-return-left"></i>
                                    </button>
                    </div>
                </form>

            </div>
        </li>

    @endforeach
    <li class="list-group-item list-group-item-action  lh-sm" aria-current="true">
        {{ $results->withQueryString()->links() }}
    </li>
</ul>
