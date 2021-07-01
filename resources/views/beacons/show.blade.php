<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Show Beacon">
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
            }

            #beacon-div {
                height: 60%;
                padding: 40px;
                font-size: 20px;
            }

            #map {
                height: 40%;
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
        </style>

        <title>Beacons</title>
    </head>

    <body class="overflow-hidden">
        <div class="w-100 vh-100 d-flex flex-row" id="main-div">
            <div class="bg-dark w-100 d-flex flex-row justify-content-between text-white" id="header">
                <h1>Beacon</h1>
                <div>
                    <a href="{{ route('beacons.edit', $beacon) }}"><button type="button" class="btn btn-dark">Edit Beacon</button></a>
                    <a href="{{ route('beacons.index') }}"><button type="button" class="btn btn-dark">View Beacons</button></a>
                    <a href="{{ route('beacons.create') }}"><button type="button" class="btn btn-dark">Create Beacon</button></a>
                </div>
            </div>
            <div class="w-100 v-100 d-flex" id="container">
                <div class="h-100" id="div-container">
                    <div class="bg-dark w-100 text-white" id="beacon-div">
                        <div class="d-flex flex-column">
                            <label class="field">Name</label>
                            <label class="value">{{ $beacon->name }}</label>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Description</label>
                            <label class="value">{{ $beacon->description ?? 'none' }}</label>
                        </div>
                        <div class="d-flex flex-column w-100" id="coords-div">
                            <label class="field">Position</label>
                            <div class="d-flex flex-row justify-content-around text-center w-100">
                                <div class="d-flex flex-column flex-grow-1">
                                    <label>Latitude</label>
                                    <label class="value">{{ $beacon->lat }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label>Longitude</label>
                                    <label class="value">{{ $beacon->lng }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Rotation</label>
                            <div class="d-flex flex-row justify-content-around text-center w-100">
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">X</label>
                                    <label class="value">{{ json_decode($beacon->rotation)->x }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">Y</label>
                                    <label class="value">{{ json_decode($beacon->rotation)->y }}</label>
                                </div>
                                <div class="d-flex flex-column flex-grow-1">
                                    <label class="subfield">Z</label>
                                    <label class="value">{{ json_decode($beacon->rotation)->z }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <label class="field">Model</label>
                            <label class="value">{{ $beacon->icon ? substr($beacon->icon, strpos($beacon->icon, '-') + 1) : 'none' }}</label>
                        </div>
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
                draggable: false,
                zoomControl: true,
                scrollwheel: false,
                disableDoubleClickZoom: true,
            });

            function selectPosition(lat, lng) {

            }
		</script>
    </body>
</html>
