<div class="row g-5">
    <div class="col-lg-12">
        @if(isset($category))
            <form class="needs-validation justify-content-center text-center" method="post"
                  action="{{ route('categories.update', $category->id) }}">
                @method('patch')
                @else
                    <form class="needs-validation justify-content-center text-center" method="post"
                          action="{{ route('categories.store') }}">
                        @endif
                        @csrf
                        <div class="row g-3">

                            <div class="col-12">
                                <div class="input-group has-validation justify-content-center m-auto">
                                    <span class="input-group-text">₽</span>
                                    @if(isset($category))
                                        <input type="text" class="form-control form-control-lg"
                                               value="{{$category->title}}" name="title" id="title"
                                               placeholder="название категории" autocomplete="off">
                                    @else
                                        <input type="text" class="form-control form-control-lg" name="title" id="title"
                                               placeholder="название категории" autocomplete="off">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="justify-content-center m-auto">
                                    @if(isset($category))
                                        <button class="btn btn-success btn-lg w-50" type="submit"><i
                                                class="bi bi-send"></i> Изменить категорию
                                        </button>
                                    @else
                                        <button class="btn btn-primary btn-lg w-50" type="submit"><i
                                                class="bi bi-send"></i> Добавить категорию
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>
    </div>
</div>
