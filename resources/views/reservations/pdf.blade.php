<!DOCTYPE html>
<html>

<head>
    <title>Reservationse List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #000;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Reservations List</h2>
    <table>

        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Date of returning</th>
                <th>Price</th>
                <th>Deposit</th>
                <th>Remaining payment</th>
                <th>Extra requirement</th>
            </tr>

        </thead>
        <tbody>
            @foreach($reservations as $index=>$reservation)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$reservation->date}}</td>
                <td>{{$reservation->returning_date}}</td>
                <td>{{$reservation->price}}</td>
                <td>{{$reservation->deposit}}</td>
                <td>{{$reservation->remaining_payment}}</td>
                <td>{{$reservation->extra_requirement}}</td>
            </tr>


            @endforeach
        </tbody>
    </table>
</body>

</html>