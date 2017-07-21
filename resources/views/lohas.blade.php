<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOHAS</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0XU4Sm4HXgdNSE-FIat3Nvd7rikkBZF4&libraries=places"></script>
    <style>
        a {
            font-family: Microsoft JhengHei;
            font-weight: bold;
            color: #FFFFFF !important;
        }
        .navbar-default {
            background-color: #16162D;
        }
        #map {
        height: 700px;
        width: 100%;
        }
        .btn-default {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">L O H A S 樂活</a>
            </div>
            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" id="address" class="form-control navbar-left" placeholder="Search">
                </div>
                <button type="button" class="btn btn-default" onclick="getaddress()">Submit</button>
            </div>
        </div>
        <div id="map"></div>
    </nav>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      // 取得 Gears 定位發生錯誤
        function errorCallback(err) {
            var msg = 'Error retrieving your location: ' + err.message;
            alert(msg);
        }

      // 成功取得 Gears 定位
        function successCallback(p) {
            mapServiceProvider(p.latitude, p.longitude);
        }

      // 顯示經緯度
        function mapServiceProvider(latitude, longitude) {
            alert('經緯度：' + latitude + ', ' + longitude);
            var uluru = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 16,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }

        function initMap() {
           // 瀏覽器支援 HTML5 定位方法
            if (navigator.geolocation) {
        // HTML5 定位抓取
                navigator.geolocation.getCurrentPosition(function (position) {
                    mapServiceProvider(position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    switch (error.code) {
                        case error.TIMEOUT:
                            alert('連線逾時');
                        break;

                        case error.POSITION_UNAVAILABLE:
                            alert('無法取得定位');
                        break;

                        case error.PERMISSION_DENIED: // 拒絕
                            alert('想要參加本活動，\n記得允許手機的GPS定位功能喔!');
                        break;

                        case error.UNKNOWN_ERROR:
                            alert('不明的錯誤，請稍候再試');
                        break;
                    }
                });
            } else { // 不支援 HTML5 定位
        // 若支援 Google Gears
                 if (window.google && google.gears) {
                    try {
            // 嘗試以 Gears 取得定位
                        var geo = google.gears.factory.create('beta.geolocation');
                        geo.getCurrentPosition(successCallback, errorCallback, { enableHighAccuracy: true, gearsRequestAddress: true });
                    } catch (e) {
                        alert('定位失敗請稍候再試');
                    }
                } else {
                    alert('想要參加本活動，\n記得允許手機的GPS定位功能喔!');
                }
            }
        }
        function getaddress() {
            var address = document.getElementById("address").value;
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    document.getElementById("lat").value=results[0].geometry.location.lat();
                    document.getElementById("lng").value=results[0].geometry.location.lng();
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    showAddress(results[0], marker);
                } else {
                    alert("失敗, 原因: " + status);
                }
            });
        }
        function showAddress(result, marker) {
            var popupContent = result.formatted_address;
            popup.setContent(popupContent);
            popup.open(map, marker);
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0XU4Sm4HXgdNSE-FIat3Nvd7rikkBZF4&callback=initMap">
    </script>
</body>


</html>
