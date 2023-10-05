<!DOCTYPE html>
<html>
<head>
	<title>Tabel Catatan Susu</title>
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
		<h4>Laporan Catatan Susu Peternakan</h4>
        <h5> {{ now()->format('D d-m-Y') }} </h5>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Jenis</th>
				<th>Produksi</th>
				<th>Konsumsi</th>
				<th>Jumlah Kambing</th>
				<th>Id_goat</th>
				<th>Pemilik</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">
            @foreach ($milknotes as $item)
            
				<tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $item?->date ?? "-" }}</td>
					<td>{{ $item?->type ?? "-" }}</td>
					<td>{{ $item?->produced ?? "-" }}</td>
					<td>{{ $item?->consumption ?? "-" }}</td>
					<td>{{ $item?->goats_milked ?? "-" }}</td>
					<td>{{ $item?->goat?->id ?? "-" }}</td>
					<td>{{ $item?->user->name ?? '-' }}</td>
				</tr>
                
            @endforeach
		</tbody>
	</table>
 
</body>
</html>