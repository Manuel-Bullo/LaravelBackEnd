<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Create Beacon">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCis0s71mPE0AuOdGdlWcn_Qw5610aWZu0"></script>
        <!-- https://cyphercodes.github.io/location-picker/docs/ -->
		<script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

        <style>
            #map {
                top: -8px;
                left: -8px;
				width: calc(100% + 16px);
				height: 100vh;
                z-index: 0;
			}

            #form-container {
                position: absolute;
                width: 350px;
                top: 100vh;
                transform: translate(5%, -105%);
                padding: 10px 10px 0 10px;
                border-radius: 1%;
                z-index: 1;
            }

            #title {
                font-size: 35px;
            }

            #rotation-label {
                background-color: #1E2125;
            }

            #btn-container {
                transform: translate(0, -15px);
            }
        </style>

        <title>Beacon Creator</title>
    </head>

    <body class="overflow-hidden text-white">
        <div id="map"></div>

        <div class="bg-dark" id="form-container">
            <form class="row g-3" enctype="multipart/form-data" id="form" method="POST" action="{{ route("beacons.store") }}">
                @csrf

                <div>
                    <label id="title">Beacon</label>
                </div>
                <div class="col-md-12">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-12">
                  <label for="description" class="form-label">Description</label>
                  <input type="text" class="form-control" id="description" name="description">
                </div>
                <div class="col-6">
                  <label for="lat" class="form-label">Latitude</label>
                  <input type="number" step="any" oninput="updatePosition();" class="form-control" id="lat" name="lat" required>
                </div>
                <div class="col-6">
                  <label for="lng" class="form-label">Longitude</label>
                  <input type="number" step="any" oninput="updatePosition();" class="form-control" id="lng" name="lng" required>
                </div>
                <div class="col-md-12 text-center d-flex flex-column" id="rotation-val-container">
                    <label id="rotation-label">Rotation</label>
                    <div class="d-flex justify-content-between" id="rotation-val">
                        <div class="col-3">
                            <label for="rotationX" class="form-label">X</label>
                            <input type="number" step="any" min=0 max=360 value=0 class="form-control" id="rotationX" name="rotationX" required>
                        </div>
                        <div class="col-3">
                            <label for="rotationY" class="form-label">Y</label>
                            <input type="number" step="any" min=0 max=360 value=0 class="form-control" id="rotationY" name="rotationY" required>
                        </div>
                        <div class="col-3">
                            <label for="rotationZ" class="form-label">Z</label>
                            <input type="number" step="any" min=0 max=360 value=0 class="form-control" id="rotationZ" name="rotationZ" required>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="file-obj" class="form-label">3D Model (OBJ)</label>
                    <input type="file" accept=".obj" class="form-control" id="file-obj" name="icon">
                </div>
                <div class="col-12">
                    <label for="file-mtl" class="form-label">3D Model (MTL)</label>
                    <input type="file" accept=".mtl" class="form-control" id="file-mtl" name="mtl">
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-dark w-100" onclick="getMarkerPosition();">Get Marker Position</button>
                </div>
                <div class="col-12 d-flex" id="btn-container">
                  <a href="{{ route('beacons.index') }}" class="flex-grow-1"><button type="button" class="btn btn-dark w-100">View Beacons</button></a>
                  <button type="submit" class="btn btn-dark flex-grow-1">Create Beacon</button>
                </div>
            </form>
        </div>

        <script>
			var locationPicker = new locationPicker('map', {
				setCurrentPosition: true,
			}, {
				zoom: 15
			});

            function getMarkerPosition() {
                let latInput = document.getElementById('lat');
                let lngInput = document.getElementById('lng');
                let responseCoords = locationPicker.getMarkerPosition();

                latInput.value = responseCoords.lat;
                lngInput.value = responseCoords.lng;
            }

            function updatePosition() {
                let lat = parseFloat(document.getElementById('lat').value);
                let lng = parseFloat(document.getElementById('lng').value);

                locationPicker.map.setCenter({lat: lat, lng: lng});
            }
		</script>
    </body>
</html>
