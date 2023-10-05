<!DOCTYPE html>
<html>
<head>
	<title>Tabel Kambing</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		table {
			width: 100%;
			table-layout: auto;
		}

		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
</head>
<body style="position: relative">
	<center>
		<h4>Laporan Data Kambing</h4>
        <h5> {{ now()->format('D d-m-Y') }} </h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>TAG</th>
				<th>Id_goat</th>
				<th>Asal</th>
				<th>Jenis</th>
				<th>Sex</th>
				<th>Berat</th>
				<th>Status</th>
				<th>Tgl Masuk</th>
				<th>Pemilik</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">
            @foreach ($goats as $goat)
            
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $goat?->name ?? "-" }}</td>
                <td>{{ $goat?->tag ?? "-" }}</td>
                <td>{{ $goat?->id ?? "-" }}</td>
                <td>{{ $goat?->origin ?? "-" }}</td>
                <td>{{ $goat?->breed ?? "-" }}</td>
                <td>{{ $goat?->gender ?? "-" }}</td>
                <td>{{ $goat?->weight ?? "-" }}</td>
                <td>{{ $goat?->status ?? "-" }}</td>
                <td>{{ $goat?->date_in->format('d-m-Y') ?? "-" }}</td>
                <td>{{ $goat?->user->name ?? '-' }}</td>
            </tr>
                
            @endforeach
		</tbody>
	</table>
 
</body>
</html>