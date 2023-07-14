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
        fetch('/maps/data/' + dataDriver)
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


    function addButton(data) {
        // console.log(data)

        var btndriverContainer = document.getElementById('btndriver');

        data.locations.forEach(function(driver, index) {
            // Check if a button with the same data-driver attribute value already exists
            var existingButton = btndriverContainer.querySelector('[data-driver="' + index + '"]');

            if (!existingButton) {
                var button = document.createElement('button');
                button.type = 'button';
                button.classList.add('btn', 'btn-primary');
                button.innerText = 'Driver ' + parseInt(index + 1);
                button.setAttribute('data-driver', parseInt(index));
                button.addEventListener('click', function() {
                    // Handle button click event
                    var driverNumber = button.getAttribute('data-driver');
                    // console.log('Button clicked for Driver ' + driverNumber);

                    // Call a function when the button is clicked
                    onLoad(driverNumber);
                    showTable(driverNumber, data);
                });
                btndriverContainer.appendChild(button);
            }
        });
    }



    function showTable(driverNumber, data) {
        // Hapus tabel lama jika ada
        var tableContainer = document.getElementById('tableContainer');
        // console.log(tableContainer.firstChild, 'tableContainer');
        if (tableContainer.firstChild) {
            // console.log(tableContainer.firstChild, 'tableContainer');

            tableContainer.removeChild(tableContainer.firstChild);
        }

        // Buat elemen tabel
        var table = document.createElement('table');
        table.classList.add('table-style'); // Tambahkan kelas CSS untuk gaya tabel
        table.style.border = '1px solid black';
        // Buat elemen tabel kepala (header)
        var tableHead = document.createElement('thead');
        var headRow = tableHead.insertRow();
        var headCell1 = headRow.insertCell();
        var headCell2 = headRow.insertCell();
        var headCell3 = headRow.insertCell();
        headCell1.textContent = 'Nama';
        headCell2.textContent = 'Lokasi';
        headCell3.textContent = 'Jarak';
        table.appendChild(tableHead);

        // Buat elemen tabel body
        var tableBody = document.createElement('tbody');
        // Isi tabel dengan data, misalnya dari objek driver
        var driverData = getDriverData(data, driverNumber); // Ganti dengan fungsi yang mengembalikan data driver berdasarkan nomor driver
        console.log(driverData, 'daatta')
        for (var i = 0; i < driverData.dataDriver.length; i++) {
            var row = tableBody.insertRow();
            var cell1 = row.insertCell();
            var cell2 = row.insertCell();
            var cell3 = row.insertCell();
            cell1.textContent = driverData.dataDriver[i]['name'];
            cell2.textContent = driverData.dataDriver[i]['alamat'];
            if (i < driverData.dataJarak.length) {
                // console.log(driverData.dataJarak[i]['jarak']);
                cell3.textContent = driverData.dataJarak[i]['jarak'] + " km";
            }
        }
        table.appendChild(tableBody);

        // Sisipkan tabel ke dalam elemen yang sesuai di halaman
        tableContainer.appendChild(table);
    }


    function getDriverData(data, driverNumber) {
        var data = {
            bla: 123,
            driver: driverNumber,
            dataJarak: data.dataJarak[driverNumber],
            dataDriver: data.data[driverNumber] // Lengkapi dengan logika untuk mendapatkan data driver yang sesuai dari objek data
        };

        return data;
    }



    function initMap(data) {


        // console.log(data, 'data');

        const myLatLng = {
            lat: -6.340748,
            lng: 108.315415
        };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
        });


        var locations = data.locations[data.driver];
        var lines = data.lines[data.driver];

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
                    <div class="card-body">
                        <div id="map"></div>
                        @if(auth()->user()->level == 1)

                        <div id="btndriver"></div>
                        <div id="tableContainer"></div>
                        <div class="col-md-12">

                        </div>
                        @endif

                    </div>
                    <!-- untuk admin -->
                    <!-- <button>driver a</button>
                    <button>driver b</button>
                    <button>driver c</button> -->
                    <!-- untuk admin -->


                    <!-- @if(auth()->user()->level == 1)

                    <div class="container-fluid ">

                        <div class="row justify-center">

                            <div class="col-md-12">
                                <div id="tableContainer"></div>

                            </div>

                        </div>
                    </div>
                    @endif -->

                    <!-- jika login driver
                    nama_driver lokasi jarak_km -->

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>

<!-- @include('layout.footer') -->
@include('layout.js')
