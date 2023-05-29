@extends('layouts.main')
@section('content')

    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold">Доходы <> Расходы</h1>
        <div class="col-lg-6 mx-auto">
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <button type="button" disabled class="btn btn-primary btn-lg px-4 gap-3">Доходы</button>
                <a href="{{ route('messages.create') }}">
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Расходы</button>
                </a>
            </div>
        </div>
    </div>
@endsection
