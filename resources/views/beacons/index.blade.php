<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Beacon Creator">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            #main-div {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            table td, table th {
                border: 1px solid #ddd;
                padding: 8px;
            }

            table tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            table tr:hover {
                background-color: #ddd;
            }

            table th {
                text-align: left;
                background-color: #04AA6D;
                color: white;
            }
        </style>

        <title>Beacons</title>
    </head>

    <body>
        <div id="main-div">
            <table>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>description</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th>icon</th>
                </tr>

                @foreach ($beacons as $beacon)
                    <tr>
                        <td>{{ $beacon->id }}</td>
                        <td>{{ $beacon->name }}</td>
                        <td>{{ $beacon->description }}</td>
                        <td>{{ $beacon->lat }}</td>
                        <td>{{ $beacon->lng }}</td>
                        <td>
                            @isset($beacon->icon)
                                <img src="{{ asset("storage/$beacon->icon") }}" width=64 height=64 />
                            @endisset
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
