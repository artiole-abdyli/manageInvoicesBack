<!DOCTYPE html>
<html>

<head>
    <title>Contacts List</title>
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
    <h2>Contacts List</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>City</th>
                <th>Country</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $index => $contact)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $contact->firstname }}</td>
                <td>{{ $contact->lastname }}</td>
                <td>{{ $contact->city }}</td>
                <td>{{ $contact->country }}</td>
                <td>{{ $contact->phone_number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>