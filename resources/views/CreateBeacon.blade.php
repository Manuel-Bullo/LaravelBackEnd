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
    </style>

    <title>Beacon Creator</title>
</head>

<body>
    <div id="main">
        <form id="form" method="POST" action="{{ route("beacons.store") }}">
            @csrf

            <p class="title"><strong>Beacon</strong></p>
            <div class="input">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required />
            </div>
            <div class="input">
                <label for="lat">Latitude</label>
                <input type="number" id="lat" name="lat" required />
            </div>
            <div class="input">
                <label for="lng">Longitude</label>
                <input type="number" id="lng" name="lng" required />
            </div>
            <input type="submit" value="Create Beacon" />
        </form>
        <div id="inner-circle"></div>
    </div>
</body>

</html>
