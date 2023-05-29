<div class="row g-5">
    <div class="col-lg-12">
        <form class="needs-validation justify-content-center text-center" method="post" action="{{ route('categories.store') }}">
            @csrf
            <div class="row g-3">

                <div class="col-12">
                    <div class="input-group has-validation justify-content-center m-auto">
                        <span class="input-group-text">₽</span>
                        <input type="text" class="form-control form-control-lg" name="title" id="title"
                               placeholder="название категории" autocomplete="off">

                        <div class="invalid-feedback">
                            ERROR
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="justify-content-center m-auto">
                        <button class="btn btn-primary btn-lg w-50" type="submit"><i class="bi bi-send"></i> Добавить категорию</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
