<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Beacon Creator">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCis0s71mPE0AuOdGdlWcn_Qw5610aWZu0"></script>
		<script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

        <style>
            body {
                font-size: 100%;
            }

            div#main-div {
                background-color: #5f9ea0;
                width: 300px;
                height: 300px;
                position: absolute;
                top: 100vh;
                left: 0;
                transform: translate(2%, -110%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }

            form {
                width: 100%;
            }

            .input {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .title {
                font-weight: 500;
            }

            div#coords {
                display: flex;
                flex-direction: row;
                justify-content: center;
            }

            div#coords div {
                width: 20%;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            div#coords div div {
                width: 100%;
            }

            div#btn-container {
                display: flex;
                flex-direction: row;
            }

            div#btn-container {
                width: 100%;
                display: flex;
            }

            div#btn-container * {
                flex-grow: 1;
            }

            div#btn-container a button {
                width: 100%;
                height: 100%;
            }

            #map {
				width:  100%;
				height: 100vh;
			}

            #coords-selector-btn {
                width: 100%;
            }
        </style>

        <title>Beacon Creator</title>
    </head>

    <body>
        <div id="map"></div>

        <div id="main-div">
            <button type="button" id="coords-selector-btn" onclick="getMarkerPosition();">Get Marker Position</button>

            <form enctype="multipart/form-data" id="form" method="POST" action="{{ route("beacons.store") }}">
                @csrf

                <p class="title"><strong>Beacon</strong></p>
                <div class="input">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required />
                </div>
                <div class="input">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" />
                </div>
                <div class="input">
                    <label for="lat">Latitude</label>
                    <input type="number" step="any" id="lat" name="lat" required />
                </div>
                <div class="input">
                    <label for="lng">Longitude</label>
                    <input type="number" step="any" id="lng" name="lng" required />
                </div>
                <div>
                    <label>Rotation</label>
                    <div id="coords">
                        <div>
                            <label for="rotationX">X</label>
                            <input type="number" class="input" value=0 min=0 max=360 step="any" id="rotationX" name="rotationX" required />
                        </div>
                        <div>
                            <label for="rotationY">Y</label>
                            <input type="number" class="input" value=0 min=0 max=360 step="any" id="rotationY" name="rotationY" required />
                        </div>
                        <div>
                            <label for="rotationZ">Z</label>
                            <input type="number" class="input" value=0 min=0 max=360 step="any" id="rotationZ" name="rotationZ" required />
                        </div>
                    </div>
                </div>
                <div class="input">
                    <label for="icon">Icon</label>
                    <input type="file" id="icon" name="icon" accept="image/*" />
                </div>
                <div id="btn-container">
                    <a href="{{ route('beacons.index') }}"><button type="button">View Beacons</button></a>
                    <input type="submit" value="Create Beacon" />
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
		</script>
    </body>
</html>
