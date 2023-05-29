<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <form action="{{ route('st.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" class="form-control" name="file" id="file" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button class="btn btn-outline-secondary" type="submit"  id="inputGroupFileAddon04">Button</button>
                </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @foreach($sts as $st)
                <div>{{$st->id}}</div>
                <img src="{{ asset('storage/'.$st->file) }}" alt="{{ $st->file }}">
            @endforeach


        </div>
    </div>
</div>

</body>
</html>
