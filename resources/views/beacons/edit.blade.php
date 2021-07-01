<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Edit Beacon">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCis0s71mPE0AuOdGdlWcn_Qw5610aWZu0"></script>
        <!-- https://cyphercodes.github.io/location-picker/docs/ -->
        <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

        <style>
            #header {
                position: fixed;
                height: 55px;
                z-index: 1;
            }

            #header h1 {
                padding-left: 10px;
            }

            #header button {
                width: 190px;
                height: 100%;
                border-left: 3px solid #1C1F23;
            }

            #container {
                position: absolute;
                height: calc(100vh - 55px);
                top: 55px;
            }

            #div-container {
                width: 50%;
                display: flex;
                flex-direction: column;
            }

            #beacon-div {
                height: 63%;
                padding: 40px;
                font-size: 20px;
            }

            #model-div {
                width: 50%;
                background-color: green;
            }

            .field {
                font-weight: 500;
            }

            .value {
                background-color: #2C3034;
                margin-bottom: 10px;
            }

            label {
                overflow: hidden;
            }

            #map {
                height: 37%;
            }
        </style>

        <title>Beacons</title>
    </head>

    <body class="overflow-hidden">
        <div class="w-100 vh-100 d-flex flex-row" id="main-div">
            <div class="bg-dark w-100 d-flex flex-row justify-content-between text-white" id="header">
                <h1>Beacon</h1>
                <div>
                    <a href="{{ route('beacons.show', $beacon) }}"><button type="button" class="btn btn-dark">View Beacon</button></a>
                    <a href="{{ route('beacons.index') }}"><button type="button" class="btn btn-dark">View Beacons</button></a>
                    <a href="{{ route('beacons.create') }}"><button type="button" class="btn btn-dark">Create Beacon</button></a>
                </div>
            </div>
            <div class="w-100 v-100 d-flex" id="container">
                <div class="h-100" id="div-container">
                    <div class="bg-dark w-100 text-white" id="beacon-div">
                        <form enctype="multipart/form-data" method="POST" action="{{ route("beacons.update", $beacon) }}">
                            @csrf
                            @method('PUT')

                            <div class="d-flex flex-column">
                                <label class="field">Name</label>
                                <input type="text" class="value text-white" value="{{ $beacon->name }}" placeholder="{{ $beacon->name }}" name="name" required>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="field">Description</label>
                                <input type="text" class="value text-white" value="{{ $beacon->description ?? '' }}" placeholder="{{ $beacon->description ?? '' }}" name="description">
                            </div>
                            <div class="d-flex flex-column w-100" id="coords-div">
                                <label class="field">Position</label>
                                <div class="d-flex flex-row justify-content-around text-center w-100">
                                    <div class="col-6 d-flex flex-column flex-grow-1">
                                        <label>Latitude</label>
                                        <input type="number" step="any" oninput="updatePosition();" class="value text-white" id="lat" value="{{ $beacon->lat }}" placeholder="{{ $beacon->lat }}" name="lat" required>
                                    </div>
                                    <div class="col-6 d-flex flex-column flex-grow-1">
                                        <label>Longitude</label>
                                        <input type="number" step="any" oninput="updatePosition();" class="value text-white" id="lng" value="{{ $beacon->lng }}" placeholder="{{ $beacon->lng }}" name="lng" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <label class="field">Rotation</label>
                                <div class="d-flex flex-row justify-content-around text-center w-100">
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label class="subfield">X</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->x }}" placeholder="{{ json_decode($beacon->rotation)->x }}" name="rotationX" required>
                                    </div>
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label class="subfield">Y</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->y }}" placeholder="{{ json_decode($beacon->rotation)->y }}" name="rotationY" required>
                                    </div>
                                    <div class="col-3 d-flex flex-column flex-grow-1">
                                        <label class="subfield">Z</label>
                                        <input type="number" step="any" min=0 max=360 class="value text-white" value="{{ json_decode($beacon->rotation)->z }}" placeholder="{{ json_decode($beacon->rotation)->z }}" name="rotationZ" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row justify-content-between">
                                    <label class="field">Model: {{ $beacon->icon ? substr($beacon->icon, strpos($beacon->icon, '-') + 1) : 'none' }}</label>
                                    <div class="d-flex flex-row">
                                        @isset($beacon->icon)
                                            <label for="remove-model" style="padding-right: 10px;">Delete Model</label>
                                            <input type="checkbox" class="h-100" id="remove-model" name="removeModel">
                                        @endisset
                                    </div>
                                </div>
                                <input type="file" accept=".obj" class="value" name="icon">
                            </div>
                            <div class="d-flex flex-row">
                                <button type="button" class="btn btn-dark w-50" onClick="getMarkerPosition();">Get Marker Position</button>
                                <button type="submit" class="btn btn-dark w-50">Update Beacon</button>
                            </div>
                        </form>
                    </div>
                    <div class="w-100" id="map"></div>
                </div>
                <div id="model-div">
                    <!-- Model View -->
                </div>
            </div>
        </div>

        <script>
			var locationPicker = new locationPicker('map', {
				lat: {{ $beacon->lat }},
                lng: {{ $beacon->lng }},
			}, {
				zoom: 18,
                draggable: true,
                zoomControl: true,
                scrollwheel: true,
                disableDoubleClickZoom: true,
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
