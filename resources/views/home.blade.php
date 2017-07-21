<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOHAS</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<style>
    body {
        color: #CABEE8;
    }
    .titleview {
        font-size: 50px;
        color: #000000;
        font-family: Microsoft JhengHei;
        font-weight: bold;
        margin: 60px;
    }
    .btn-primary {
        width: 200px;
        height: 50px;
        border-radius: 20px;
        font-size: 25px;
        margin-top: 220px;
        opacity:0.7;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="titleview text-center ">
                    L O H A S 樂活宅
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2" align="center">
                <button class="btn btn-primary" type="button" onclick="location.href='{{ url('/lohas') }}'">start</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>

    </script>
</body>


</html>
