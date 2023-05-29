<div class="py-5 text-center">
    <h2>Расходы</h2>
</div>
<div class="row g-5">
    @if($errors->any())

        <ul class="list-group list-group-flush list-unstyled text-center">
            @foreach($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{$error}}</li>
            @endforeach
        </ul>

    @endif
    <div class="col-lg-12">

        <form class="needs-validation justify-content-center text-center" method="post"
              action="{{ route('messages.store') }}">
            @csrf
            <div class="row g-3">

                <div class="col-12">
                    <div class="input-group has-validation justify-content-center m-auto">
                        <textarea class="form-control form-control-lg" placeholder="Leave a comment here" name="message"
                                  id="message">@if(session('data')){{ session('data') }}@endif</textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="justify-content-center m-auto">
                        <button class="btn btn-primary btn-lg w-50" type="submit"><i class="bi bi-send"></i></button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
