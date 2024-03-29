<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo</title>
</head>

<body>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
    </style>
    <h1>Activaciones pendientes</h1>
    <table style="width: 100%; border-collapse: collapse; background-color: #f9f9f9;">
        <thead>
            <tr>
                <th
                    style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd; background-color: #f2f2f2; font-weight: bold;">
                    Cliente</th>
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Fecha fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activaciones as $item)
                <tr>
                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">{{ $item['cliente'] }}
                    </td>
                    <td style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">{{ $item['fecha_fin'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
