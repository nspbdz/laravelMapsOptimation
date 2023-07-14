@include('layout.header')
@include('layout.navbar')
@include('layout.sidebar')

<style type="text/css">
    #map {
        height: 400px;
    }
</style>


<script type="text/javascript">
    var dataLoc = [];
    //     window.onload = function() {
    //     onLoad(0);
    // };

    document.addEventListener('DOMContentLoaded', function() {
        onLoad(0); // Jalankan fungsi fetchData saat halaman selesai dimuat
    });

    function onLoad(dataDriver = null) {
        event.preventDefault(); // Mencegah reload halaman

        // console.log(dataDriver, 'dataDriver');
        fetch('/pso/data/' + dataDriver)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                // Handle the response data
                // console.log(data);
                dataLoc = data;
                initMap(dataLoc)
                addButton(dataLoc)

                // Perform any additional actions or update the UI based on the data
            })
            .catch(function(error) {
                // Handle any errors
                console.error('Error:', error);
            });
        // Perform actions or initialization tasks when the page is loaded
        // ...
    }



   
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


                    @if(auth()->user()->level == 1)
                    <div class="container-fluid ">

                        <div class="row justify-center">
                            <div id="btndriver"></div>
                        </div>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

@include('layout.footer')
@include('layout.js')
