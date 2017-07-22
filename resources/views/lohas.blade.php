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
            font-size:30px !important;
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

        .controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 300px;
      }

      #pac-input:focus {
            border-color: #4d90fe;
      }

      .pac-container {
            font-family: Roboto;
      }

      #type-selector {
            color: #fff;
            background-color: #4d90fe;
            padding: 5px 11px 0px 11px;
      }

      #type-selector label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
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
                <input id="pac-input" class="form-control controls" type="text" placeholder="Enter a location">
                <div id="type-selector" class="controls">
                    <input type="radio" name="type" id="changetype-all" checked="checked">
                    <label for="changetype-all">All</label>
                    <input type="radio" name="type" id="changetype-establishment">
                    <label for="changetype-establishment">Establishments</label>
                    <input type="radio" name="type" id="changetype-address">
                    <label for="changetype-address">Addresses</label>
                    <input type="radio" name="type" id="changetype-geocode">
                    <label for="changetype-geocode">Geocodes</label>
                </div>
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
            var uluru = {lat: latitude, lng: longitude};
            var map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 13
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
            var input = /** @type {!HTMLInputElement} */(document.getElementById('pac-input'));
            var types = document.getElementById('type-selector');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);
            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });
            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }
                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);
            });
            function setupClickListener(id, types) {
                var radioButton = document.getElementById(id);
                radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
                });
            }
            setupClickListener('changetype-all', []);
            setupClickListener('changetype-address', ['address']);
            setupClickListener('changetype-establishment', ['establishment']);
            setupClickListener('changetype-geocode', ['geocode']);
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
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOWZr0adSty-fCCs1Qr_sjSHTDxSO2iB4&callback=initMap">
    </script>
    <script  async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOWZr0adSty-fCCs1Qr_sjSHTDxSO2iB4&libraries=places&callback=initMap">
    </script>
</body>
</html>
