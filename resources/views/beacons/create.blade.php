<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Beacon Creator">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            body {
                background-color: darkgray;
                font-size: 200%;
            }

            div#main {
                background-color: #5f9ea0;
                width: 400px;
                height: 400px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                border-radius: 100%;
                z-index: 1;
            }

            div#main * {
                z-index: 3;
            }

            div#inner-circle {
                background-color: #9f9ea0;
                position: absolute;
                width: 100px;
                height: 100px;
                border-radius: 100%;
                z-index: 2;
            }

            form {
                width: 100%;
            }

            input {
                width: 50%;
            }

            div.input {
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
            }

            div#coords div {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        </style>

        <title>Beacon Creator</title>
    </head>

    <body>
        <div id="main">
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
                <div class="input">
                    <label>Rotation</label>
                    <div id="coords">
                        <div>
                            <label for="rotationX">X</label>
                            <input type="number" value=0 min=0 max=360 step="any" id="rotationX" name="rotationX" required />
                        </div>
                        <div>
                            <label for="rotationY">Y</label>
                            <input type="number" value=0 min=0 max=360 step="any" id="rotationY" name="rotationY" required />
                        </div>
                        <div>
                            <label for="rotationZ">Z</label>
                            <input type="number" value=0 min=0 max=360 step="any" id="rotationZ" name="rotationZ" required />
                        </div>
                    </div>
                </div>
                <div class="input">
                    <label for="icon">Icon</label>
                    <input type="file" id="icon" name="icon" accept="image/*" />
                </div>
                <input type="submit" value="Create Beacon" />
            </form>
            <div id="inner-circle"></div>
            <a href="{{ route('beacons.index') }}"><button>View Beacons</button></a>
        </div>
    </body>

</html>
