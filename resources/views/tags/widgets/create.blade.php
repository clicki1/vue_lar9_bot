<div class="row">
    <div class="col-sm-12">
        @if($errors->any())

            <ul class="list-group list-group-flush list-unstyled text-center">
                @foreach($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{$error}}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
<div class="row g-5">
    <div class="col-lg-12">
        @if(isset($tag))
            <form class="needs-validation justify-content-center text-center" method="post"
                  action="{{ route('tags.update', $tag->id) }}">
                <input type="hidden"  name="tag_id" value="{{$tag->id}}">
                @method('patch')
                @else
                    <form class="needs-validation justify-content-center text-center" method="post"
                          action="{{ route('tags.store') }}">
                        @endif
                        @csrf
                        <div class="row mt-3">
                            <div class="col-12">
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        id="category_id" name="category_id">
                                    <option value="{{ null }}">Выберите категорию</option>
                                    @if(isset($tag))
                                        @foreach($categories as $category)

                                            <option value="{{ $category->id }}"
                                            @if(old('category_id'))
                                                {{ $category->id == old('category_id') ? 'selected' : '' }}
                                                @else
                                                {{ $category->id === $tag->category_id ? 'selected' : '' }}
                                                @endif
                                            >{{ $category->title }}</option>

                                        @endforeach
                                    @else
                                        @foreach($categories as $category)

                                            <option value="{{ $category->id }}"
                                                {{ $category->id == old('category_id') ? 'selected' : '' }}
                                            >{{ $category->title }}</option>

                                        @endforeach
                                    @endif


                                </select>
                                @error('category_id')
                                <h5 class="text-danger">{{ $message }}</h5>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-3">

                            <div class="col-12">
                                <div class="input-group has-validation justify-content-center m-auto">
                                    <span class="input-group-text">₽</span>
                                    @if(isset($tag))
                                        <input type="text" class="form-control form-control-lg"
                                               value="{{$tag->title}}" name="title" id="title"
                                               placeholder="название категории" autocomplete="off">
                                    @else
                                        <input type="text" class="form-control form-control-lg" name="title" id="title"
                                               value="{{ old('title') }}" placeholder="название тэга"
                                               autocomplete="off">
                                    @endif

                                </div>
                                @error('title')
                                <h5 class="text-danger">{{ $message }}</h5>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="justify-content-center m-auto">
                                    @if(isset($tag))
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
