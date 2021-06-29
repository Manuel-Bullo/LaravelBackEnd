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
                    <th>lat</th>
                    <th>lng</th>
                </tr>

                <?php
                    foreach ($beacons as $key) {
                        echo "<tr>";
                        echo "<td>{$key['id']}</td>";
                        echo "<td>{$key['name']}</td>";
                        echo "<td>{$key['lat']}</td>";
                        echo "<td>{$key['lng']}</td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </body>
</html>
