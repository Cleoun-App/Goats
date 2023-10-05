<!DOCTYPE html>
<html>
<head>
	<title>Tabel Event</title>
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
		<h4>Laporan Data Event Peternakan</h4>
        <h5> {{ now()->format('D d-m-Y') }} </h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jenis</th>
				<th>Cakupan</th>
				<th>Tanggal</th>
				<th>Id_goat</th>
				<th>Pemilik</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">
            @foreach ($events as $event)
            
				<tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $event?->name ?? "-" }}</td>
					<td>{{ $event?->type ?? "-" }}</td>
					<td>{{ $event?->scope ?? "-" }}</td>
					<td>{{ $event?->date ?? "-" }}</td>
					<td>{{ $event?->goat?->id ?? "-" }}</td>
					<td>{{ $event?->user->name ?? '-' }}</td>
				</tr>
                
            @endforeach
		</tbody>
	</table>
 
</body>
</html>