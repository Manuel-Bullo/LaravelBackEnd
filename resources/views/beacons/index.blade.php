<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Beacon Creator">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            #header {
                position: fixed;
                width: 100%;
                height: 55px;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                color: white;
                z-index: 1;
            }

            #header h1 {
                padding-left: 10px;
            }

            #header button {
                height: 100%;
                border-left: 3px solid #1C1F23;
            }

            #table-container {
                position: absolute;
                width: 75%;
                height: calc(100vh - 55px);
                top: 55px;
                left: 50%;
                transform: translate(-50%, 0);
                overflow-y: scroll;
                z-index: 0;
            }

            .scrollbar-danger::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                background-color: #2C3034;
                border-radius: 10px;
            }

            .scrollbar-danger::-webkit-scrollbar {
                width: 12px;
                background-color: #212529;
            }

            .scrollbar-danger::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #ff3547;
            }

            .scrollbar-danger {
                scrollbar-color: #ff3547 #212529;
            }

            ::-webkit-scrollbar-corner {
                background: #212529;
            }
        </style>

        <title>Beacons</title>
    </head>

    <body class="bg-dark">
        <div class="bg-dark" id="header">
            <h1>Beacons</h1>

            <a href="{{ route('beacons.create') }}"><button type="button" class="btn btn-dark">Create Beacon</button></a>
        </div>

        <div class="scrollbar-danger" id="table-container">
            <table class="table table-dark table-striped">
                <tr>
                    <th>name</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th>rotation</th>
                    <th>icon</th>
                    <th>edit</th>
                </tr>

                @foreach ($beacons as $beacon)
                    <tr>
                        <td>{{ $beacon->name }}</td>
                        <td>{{ $beacon->lat }}</td>
                        <td>{{ $beacon->lng }}</td>
                        <td>x: {{ json_decode($beacon->rotation)->x }}, y: {{ json_decode($beacon->rotation)->y }}, z: {{ json_decode($beacon->rotation)->z }}</td>
                        <td style="max-width: 150px; word-wrap: break-word;">
                            @isset($beacon->icon)
                                {{ basename($beacon->icon) }}
                            @endisset
                        </td>
                        <td>
                            <form action="{{ route('beacons.destroy', $beacon) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger" value="delete" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
