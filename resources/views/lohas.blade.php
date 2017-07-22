<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOHAS</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        a {
            font-family: Microsoft JhengHei;
            font-weight: bold;
            color: #FFFFFF !important;
            font-size:30px !important;
        }

        body {
            background-color: #FFFFFF;
        }

        .navbar {
            margin-bottom: 0px !important;
        }

        .navbar-default {
            background-color: #16162D;
        }

        #map {
            height: 912px;
            width: 80%;
            float: left;
        }
        .filterdata {
            height: 912px;
            width: 20%;
            float: right;
            overflow: auto;
            font-size: 30px;
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
            font-family: Microsoft JhengHei;
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

        .filter {
            font-size: 20px;
            zoom:2.0;
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            right: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover, .offcanvas a:focus{
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
        }

        .check {
            opacity:0.5;
            color:#996;
        }

        .formgroup {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">L O H A S 樂活宅</a>
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
            <span style="font-size:30px;cursor:pointer; color: #FFFFFF; float: right;" onclick="openNav()">&#9776;篩選</span>
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="formgroup">
                    <div  align="center">
                        <label class="btn btn-primary">
                        <img src="./image/live.png" class="img-thumbnail img-check">
                        <input type="checkbox" name="live" id="live" value="live">
                        </label>
                    </div>
                </div>
                <div class="formgroup">
                    <div  align="center">
                        <label class="btn btn-primary">
                        <img src="./image/traffic.png" class="img-thumbnail img-check">
                        <input type="checkbox" name="trans" id="trans" value="trans">
                        </label>
                    </div>
                </div>
                <div class="formgroup">
                    <div  align="center">
                        <label class="btn btn-primary">
                        <img src="./image/homeinfo.png" class="img-thumbnail img-check">
                        <input type="checkbox" name="homeinfo" id="homeinfo" value="homeinfo">
                        </label>
                    </div>
                </div>
                 <div class="formgroup">
                    <div align="center">
                        <button type="button" class="btn btn-primary" style="font-size:30px;" onclick="getfilterdata()">送出</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div id="map"></div>
    <div class="filterdata" align="center">

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(e){
            $(".img-check").click(function(){
                $(this).toggleClass("check");
            });
         });
        var address;
        var area;
        var map;
        var uluru;
        var infowindow;
        var markers = [];
        var count=0;
        var life_keyword = ['超商','餐廳','夜市','公園'];
        var life_type = ['gym','school'];
        var tra_keyword = ['捷運','公車','停車場'];
        var tra_type = ['train_station'];
        var data = {超商: 0, 餐廳:0 ,夜市:0,公園:0,gym:0,school:0,捷運:0,train_station:0,公車站:0,停車場:0};
        var price = {士林區: 149640, 大同區: 281971, 中山區: 1033410.356, 中正區: 878805.0735,  內湖區: 1088847.912,  文山區: 350733.1127,  北投區:113765.8082, 松山區:72343.74428,  信義區:295659.9596,  南港區:127526.0118,  萬華區:232842.0301};
        function searchKeyword(word){
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
                location: uluru,
                radius: 500,
                keyword : word
             }, function(results, status){
                if (results.length)
                     data[word] = results.length;
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarker(results[i]);
                        }
                    }
                });
             }
        function searchType(searchtype){
            infowindow = new google.maps.InfoWindow();
            var service = new google.maps.places.PlacesService(map);
            service.nearbySearch({
                location: uluru,
                radius: 500,
                type : searchtype
            }, function(results, status){
                if(results.length > 0)
                    data[searchtype] = results.length;
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                        createMarker(results[i]);
                        console.log(searchtype+" : "+data.searchtype);
                     }
                }
            });
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });
            markers.push(marker);

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(place.name);
                infowindow.open(map, this);
            });
        }

        function DeleteMarkers() {
        //Loop through all the markers and remove
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        };

        function addLife() {
            for (var i = 0 ; i < life_keyword.length; i++){
                searchKeyword(life_keyword[i]);
            }
            for (var i = 0 ; i < life_type.length; i++){
                searchType(life_type[i]);
            }
        }

        function addtrans() {
            for (var i = 0 ; i < tra_keyword.length; i++){
                console.log(tra_keyword[i]+"i="+i);
                searchKeyword(tra_keyword[i]);
            }
            for (var i = 0 ; i < tra_type.length; i++){
                console.log(tra_type[i]);
                searchType(tra_type[i]);
            }
        }
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
            // alert('經緯度：' + latitude + ', ' + longitude);
            uluru = {lat: latitude, lng: longitude};
            map = new google.maps.Map(document.getElementById('map'), {
                center: uluru,
                zoom: 13
            });
            var image = {
                url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                // This marker is 20 pixels wide by 32 pixels high.
                size: new google.maps.Size(20, 32),
                // The origin for this image is (0, 0).
                origin: new google.maps.Point(0, 0),
                // The anchor for this image is the base of the flagpole at (0, 32).
                anchor: new google.maps.Point(0, 32)
            };
            var marker = new google.maps.Marker({
              position: uluru,
              icon: image,
              map: map
            });
            markers.push(marker);

            addLife();
            addtrans();
            // searchType("train_station");
            var input = /** @type {!HTMLInputElement} */(
                document.getElementById('pac-input'));

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
                area = place.address_components[0].short_name;
                console.log(area);
          //---------------------------search--------------
                uluru = place.geometry.location;
                DeleteMarkers();
                addLife();
                addtrans();
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

        function openNav() {
            document.getElementById("mySidenav").style.width = "400px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function getfilterdata() {
            $('.filterdata').empty();
            var live = document.getElementById('live');
            var trans = document.getElementById('trans');
            var homeinfo = document.getElementById('homeinfo');
            if (live.checked) {
                addLife();
                $('.filterdata').append("<img src='./image/store.png'>"+" : "+data['超商']+"</img><br/>");
                $('.filterdata').append("<img src='./image/restaurant.png'>"+" : "+data['餐廳']+"</img><br/>");
                $('.filterdata').append("<img src='./image/market.png'>"+" : "+data['夜市']+"</img><br/>");
                $('.filterdata').append("<img src='./image/park.png'>"+" : "+data['公園']+"</img><br/>");
                $('.filterdata').append("<img src='./image/school.png'>"+" : "+data['school']+"</img><br/>");
            }
            if (trans.checked) {
                addtrans();
                $('.filterdata').append("<img src='./image/bus.png'>"+" : "+data['公車']+"</img><br/>");
                $('.filterdata').append("<img src='./image/MRT.png'>"+" : "+data['捷運']+"</img><br/>");
                $('.filterdata').append("<img src='./image/P.png' style='width:100px;height:100px'>"+" : "+data['停車場']+"</img><br/>");
            }
            if (homeinfo.checked) {
                $('.filterdata').append("<img src='./image/price.png'>"+" : "+price[area]+"</img><br/>");
            }

            closeNav();
        }
    </script>
    <script  async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOWZr0adSty-fCCs1Qr_sjSHTDxSO2iB4&libraries=places&callback=initMap">
    </script>
</body>
</html>
