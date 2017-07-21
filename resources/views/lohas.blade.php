<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOHAS</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        div.formgroup {
            margin-top: 30px;
        }
        label {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">L O H A S 樂活宅</a>
            </div>
        </div>
    </nav>
    <div class="container" align="center">
        <div class="row">
            <form action="/api/getfactory" method="get">
                <div class="formgroup">
                    <label class="col-md-1 label-control">X座標:</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" id="x">
                    </div>
                </div><br />
                <div class="formgroup">
                    <label class="col-md-1 label-control">Y座標:</label>
                    <div class="col-md-2">
                        <input class="form-control" type="text" id="y">
                    </div>
                </div><br />
                <div class="formgroup">
                    <label class="col-md-2 label-control">選取範圍:</label>
                    <div class="col-md-1">
                        <input class="form-control" type="text" id="buffer">
                    </div>
                </div><br />
                <div class="formgroup">
                    <div class="col-md-1">
                        <input class="form-control" type="submit" value="送出">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>


</html>
