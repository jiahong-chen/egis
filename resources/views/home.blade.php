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
        background-color: #16162D;
    }
    .titleview {
        font-size: 50px;
        font-family: Microsoft JhengHei;
        font-weight: bold;
        color: #FFFFFF;
        margin: 60px;
    }
    .btn-primary {
        width: 200px;
        height: 50px;
        border-radius: 20px;
        font-size: 25px;
        margin-top: 150px;
        opacity:0.7;
    }
    span {
        font-size: 33px;
        font-family: Microsoft JhengHei;
        font-weight: bold;
        color: #FFFFFF;

    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="titleview text-center ">
                    L O H A S 樂 活
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2" align="center">
                <span>為了讓人們選擇</span><br />
                <span>自己所需求的</span><br />
                <span>因此，</span><br />
                <span>我們為你打造了專屬於你/妳的生活圈</span>
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
