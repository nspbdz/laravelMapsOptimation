@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')

<style type="text/css">
    body {
        height: 150vh;
        background-color: #ddd;
    }

    #btndriver {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    #btndriver button {
        margin: 10px;
    }

    #map {
        height: 400px;
    }

    #tableContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100vh; */
        /* Sesuaikan dengan tinggi yang diinginkan */
    }

    .table-style {
        border-collapse: collapse;
        width: 80%;
        height: 50%;
        justify-content: center;
    }

    .table-style th,
    .table-style td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table-style th {
        background-color: #f2f2f2;
    }

    .table-style tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>


<script type="text/javascript">
    const myLatLng = {
        lat: -6.340748,
        lng: 108.315415
    };

    function initMap() {
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: myLatLng
        });

        directionsRenderer.setMap(map);

        const onChangeHandler = function() {
            calculateAndDisplayRoute(directionsService, directionsRenderer);
        };

        document.getElementById("start").addEventListener("change", onChangeHandler);
        document.getElementById("end").addEventListener("change", onChangeHandler);
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        directionsService
            .route({
                origin: {
              
                    lng: 108.315415
                },
                destination: {

                    lat: -6.3404209,
                    lng: 108.3019469
                },
                travelMode: google.maps.TravelMode.DRIVING,
            })
            .then((response) => {
                directionsRenderer.setDirections(response);
            })
            .catch((e) => window.alert("Directions request failed due to " + status));
    }

    window.initMap = initMap;
</script>

<div class="page-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-6">
                <div class="card" style="width: 72rem; height: 150vh;">
                    <div class="card-header pb-0">
                        <h5>Map at a specified location</h5>
                        <span>Display a map at a specified location and zoom level.</span>
                    </div>
                    <div class="container">
                        <b>Start: </b>
                        <select id="start">
                            <option value="108.3019469">TPA PECUK</option>
                        </select>
                        <b>End: </b>
                        <select id="end">
                            <option value="108.2377">Desa Centigi Kulon</option>
                            <option value="108.2377">Desa Centigi Wetan</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

<!-- @include('layout.footer') -->
@include('layout.js')
