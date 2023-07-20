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
                initMap(dataLoc, dataDriver)
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

    function showTable(driverNumber, data, response) {
        // Hapus tabel lama jika ada
        var tableContainer = document.getElementById('tableContainer');
        if (tableContainer.firstChild) {
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
        var headCell4 = headRow.insertCell();
        headCell1.textContent = 'Nama';
        headCell2.textContent = 'Lokasi';
        headCell3.textContent = 'Estimasi Durasi';
        headCell4.textContent = 'Jarak';
        table.appendChild(tableHead);

        // Buat elemen tabel body
        var tableBody = document.createElement('tbody');
        var totalJarak = 0;
        var driverData = getDriverData(data,
            driverNumber); // Ganti dengan fungsi yang mengembalikan data driver berdasarkan nomor driver
        console.log(driverData.dataJarak, 'driverData');
        for (var i = 0; i < driverData.dataDriver.length; i++) {
            var row = tableBody.insertRow();
            var cell1 = row.insertCell();
            var cell2 = row.insertCell();
            var cell3 = row.insertCell();
            var cell4 = row.insertCell();
            cell1.textContent = driverData.dataDriver[i]['name'];
            cell2.textContent = driverData.dataDriver[i]['alamat'];

            if (i < driverData.dataJarak.length) {
                // console.log(driverData.dataJarak[i]['jarak']);
                const duration = response.routes[0].legs[i].duration.text;
                cell3.textContent = duration;

                cell3.classList.add('duration-class'); // Ganti 'jarak-class' dengan nama kelas yang Anda inginkan

            } else {
                cell3.textContent = 0 + " min";

            }

            if (i < driverData.dataJarak.length) {
                // console.log(driverData.dataJarak[i]['jarak']);
                const distance = response.routes[0].legs[i].distance.text;
                cell4.textContent = distance;

                cell4.classList.add('jarak-class'); // Ganti 'jarak-class' dengan nama kelas yang Anda inginkan

            } else {
                cell4.textContent = 0 + " km";

            }
            // cell3.textContent = driverData.dataJarak[i]['jarak'] + " km";
            // cell3.classList.add('jarak-class'); // Tambahkan kelas CSS pada elemen jarak

            if (i < driverData.dataJarak.length) {
                totalJarak += driverData.dataJarak[i]['jarak'];
            }
        }

        // Menghitung total jarak
        var totalJarak = 0;
        for (var i = 0; i < driverData.dataJarak.length; i++) {
            totalJarak += driverData.dataJarak[i]['jarak'];
        }

        // Membuat elemen baris total
        var totalRow = tableBody.insertRow();
        var totalCell1 = totalRow.insertCell();
        var totalCell2 = totalRow.insertCell();
        var totalCell3 = totalRow.insertCell();
        var totalCell4 = totalRow.insertCell();
        totalCell1.textContent = 'Total';
        totalCell2.textContent = '';
        totalCell3.textContent = '';
        totalCell4.textContent = totalJarak.toFixed(2) + " km";
        totalCell4.classList.add('total-jarak-class'); // Ganti 'total-jarak-class' dengan nama kelas yang Anda inginkan

        table.appendChild(tableBody);

        // Sisipkan tabel ke dalam elemen yang sesuai di halaman
        tableContainer.appendChild(table);
    }

    function getDriverData(data, driverNumber) {
        var data = {
            driver: driverNumber,
            dataJarak: data.dataJarak[driverNumber],
            dataDriver: data.data[
                driverNumber
            ] // Lengkapi dengan logika untuk mendapatkan data driver yang sesuai dari objek data
        };

        return data;
    }

    function initMap(data, dataDriver) {

        const myLatLng = {
            lat: -6.340748,
            lng: 108.315415
        };

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: myLatLng
        });

        directionsRenderer.setMap(map);

        let locations = data.locations[data.driver];
        let lines = data.lines[data.driver];


        let origin = {
            lat: lines[0].lat,
            lng: lines[0].lng
        }

        let destination = {
            lat: lines[lines.length - 1].lat,
            lng: lines[lines.length - 1].lng
        }

        let newLines = [...lines]

        newLines.shift();
        newLines.pop();

        const waypoints = [];
        newLines.forEach((item) => {
            waypoints.push({
                location: {

                    lat: item.lat,
                    lng: item.lng,
                },
                stopover: true,
            });
        });


        directionsService
            .route({
                origin,
                destination,
                waypoints,
                travelMode: google.maps.TravelMode.DRIVING,
                optimizeWaypoints: true,
                unitSystem: google.maps.UnitSystem.METRIC

            })
            .then((response) => {
                console.log(response)
                directionsRenderer.setDirections(response);

                const legs = response.routes[0].legs;
                for (let i = 0; i < legs.length; i++) {
                    const distance = legs[i].distance.text;
                    console.log(`Leg ${i + 1} distance: ${distance}`);
                }

                showTable(dataDriver, data, response);
            })
            .catch((e) => window.alert("Directions request failed due to " + status));


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
                        @if (auth()->user()->level == 1)
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


                    <!-- @if (auth()->user()->level == 1)
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

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}"></script>

<!-- @include('layout.footer') -->
@include('layout.js')
