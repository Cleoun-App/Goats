<!DOCTYPE html>
<html>
<head>
	<title> {{ config('app.name') }} - Tabel Event</title>
	<style type="text/css">
        body,* {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            padding: 0;
            margin: 0;
            border: none;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 5px 10px;
        }

		table {
            background-color: #2c243b;
			width: 100%;
			table-layout: auto;
            margin: 10px 0;
            border: none;
            border: solid 1px;
		}

        table tr td {
            color: #444444;
            background-color: #f1f1f1;
        }

		table tr td,
		table tr th{
            text-align: center;
			font-size: 9pt;
            margin: 0;
		}

        table tr th{
            text-transform: uppercase;
            font-weight: bold;
            background-color: #2c243a;
            color: rgb(238, 238, 238);
            font-size: 10pt;
            padding: 5px;
        }

        table.mko-table tbody tr td:first-child {
            width: 40%;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #4c4655;
            color: rgb(238, 238, 238);
            font-size: 10pt;
            padding: 5px;
        }

        .field-sum {
            background-color: #2c243b !important;
            color: whitesmoke !important;
        }

        .header h2 {
            font-size: 32px;
            text-transform: uppercase;
        }

        .header h4 {
            margin: 5px 0;
        }

        .title-sect {
            text-align: center;
            text-transform: uppercase;
			font-weight: bolder;
            color: #2c243a;
            margin-top: 15px;
            margin-bottom: 5px;
        }

	</style>
</head>
<body style="position: relative">

	<center class="header">
        <h2>{{ config('app.name') }}</h2>
		<h4>Laporan Event Peternakan</h4>
        <h5> {{ now()->format('l d F Y h:i') }} | PDF &middot; Cleoun Render Engine &middot; V1.0.7   </h5>
	</center>
 
	@foreach ($events as $etype)

		@php
            $event_types = $etype->events()->where("user_id", "=", $user_id)->get();
		@endphp
	
		<h2 class="title-sect">Tabel Event {{ $etype->name }}</h2>

		<table class='table table-bordered'>
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Jenis</th>
					<th>Cakupan</th>
					<th>Tanggal</th>
					<th>Id_goat</th>
					@foreach ($etype->field as $cloumn)
						<th>{{ $cloumn }}</th>
					@endforeach
					<th>Pemilik</th>
				</tr>
			</thead>
			<tbody style="position: relative; width: 100%">
				@foreach ($event_types as $event)
				
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>{{ $event?->name ?? "-" }}</td>
						<td>{{ $event?->type ?? "-" }}</td>
						<td>{{ $event?->scope ?? "-" }}</td>
						<td>{{ $event?->date ?? "-" }}</td>
						<td>{{ $event?->goat?->id ?? "-" }}</td>
                        @foreach ($etype->field as $cloumn)
                            @foreach ($event?->data ?? [] as $k => $data)
                                @if ($k == $cloumn)
                                    <td>{{ $data ?? "-" }}</td>
                                @endif
                            @endforeach
                        @endforeach
						<td>{{ $event?->user->name ?? '-' }}</td>
					</tr>
					
				@endforeach
			</tbody>
		</table>

	@endforeach
 
</body>
</html>