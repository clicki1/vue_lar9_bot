@extends('layouts.main')
@section('content')

    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold">Доходы <> Расходы</h1>
        <div class="col-lg-6 mx-auto">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
               <form class="needs-validation justify-content-center text-center" action="{{route('chat.login')}}" method="post">
                    @csrf
                    <input id="chat_id" class="form-control form-control-lg m-2" type="text" name="chat_id">
                    <button type="submit" class="btn btn-outline-dark btn-lg mb-4">Send</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        let chat_id = localStorage.getItem("chat_id");
        document.querySelector('#chat_id').value = chat_id;


    </script>
@endsection
