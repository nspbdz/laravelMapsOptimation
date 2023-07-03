@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')

<style type="text/css">
    #map {
        height: 400px;
    }
</style>


<script type="text/javascript">
    function initMap() {
        const myLatLng = {
            lat: -6.340748,
            lng: 108.315415
        };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
        });

        // var locations = {{ Js::from($locations) }};
        var locations = {{ Js::from($locations[1]) }};
        console.log(locations);

        // var lines = {{ Js::from($lines) }};
        var lines = {{ Js::from($lines[1]) }};

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        const linesPath = new google.maps.Polyline({
            path: lines,
            geodesic: true,
            strokeColor: "#FF0000",
            strokeOpacity: 1.0,
            strokeWeight: 2,
        });

        linesPath.setMap(map);
        console.log(locations.length, 'length')
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
            });

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));

        }


    }

    window.initMap = initMap;
</script>

<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6">
                <div class="card" style="width: 72rem; height: 40rem;">
                    <div class="card-header pb-0">
                        <h5>Map at a specified location</h5>
                        <span>Display a map at a specified location and zoom level.</span>
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                    <!-- untuk admin -->
                    <!-- <button>driver a</button>
                    <button>driver b</button>
                    <button>driver c</button> -->
                    <!-- untuk admin -->

                     driver A
                    <!-- langsung tampilkan maps nya   -->

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

@include('layout.footer')
@include('layout.js')
