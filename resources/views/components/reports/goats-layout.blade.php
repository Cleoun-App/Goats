<!DOCTYPE html>
<html>
<head>
	<title> {{ config('app.name') }} - Laporan Kambing</title>
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
			font-weight: bolder;
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
		<h4>Laporan Data Kambing</h4>
        <h5> {{ now()->format('D d-m-Y') }} | PDF &middot; Cleoun Render Engine &middot; V1.0.7   </h5>
	</center>

    
    <h2 class="title-sect">Jumlah Kambing Berdasarkan Kelamin</h2>

    <table class='table table-bordered mko-table' style="width: 45%; margin: auto;">
		<thead>
			<tr>
				<th>Jenis/Gender Kambing</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">
            
            <tr>
                <td>Jantan</td>
                <td>{{ ($user?->goats() ?? \App\Models\Goat::query())->where('gender', 'male')->count() }}</td>
            </tr>
                
            <tr>
                <td>Betina</td>
                <td>{{ ($user?->goats() ?? \App\Models\Goat::query())->where('gender', 'female')->count() }}</td>
            </tr>
            
            <tr>
                <td class="field-sum">Total</td>
                <td class="field-sum">{{ count($goats) }}</td>
            </tr>

		</tbody>
	</table>
    
    <h2 class="title-sect">Jumlah Kambing Berdasarkan Jenis</h2>

    <table class='table table-bordered mko-table' style="width: 45%; margin: auto;">
		<thead>
			<tr>
				<th>Ras/Jenis Kambing</th>
				<th>Jumlah</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">

			@php
				$sum_breed = 0;
			@endphp
            
            @foreach ($breeds as $breed)
				@php
                    if($user instanceOf \App\Models\User) {
                        $count = $breed->goats()->where('user_id', $user?->id)->count();
                    } else {
                        $count = $breed->goats()->count();
                    }
					$sum_breed += $count;
				@endphp

				<tr>
					<td>{{ $breed->name }}</td>
					<td>{{ $count }}</td>
				</tr>
			@endforeach
            
            <tr>
                <td class="field-sum">Total</td>
                <td class="field-sum">{{ $sum_breed }}</td>
            </tr>

		</tbody>
	</table>

	<br style="margin-top: 250px !important;">

    <h2 class="title-sect">Records</h2>
 
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
				<th>Group</th>
				<th>Stage</th>
				<th>Tgl Lahir</th>
				<th>Status</th>
				<th>Tgl Masuk</th>
				<th>Pemilik</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">

			@foreach ($goats as $goat)

			@php
				// Tanggal lahir kambing (gantilah dengan tanggal lahir sebenarnya yang Anda kirim dari kontroler).
				$tanggal_lahir = $goat->birth_date;
				
				// Hitung usia kambing dalam bulan
				$usia_kambing_bulan = $tanggal_lahir->diffInMonths(now());
		
				// Definisikan tahap berdasarkan usia
				if ($usia_kambing_bulan < 6) {
					$stage = "Bayi";
				} elseif ($usia_kambing_bulan < 12) {
					$stage = "Anak Kambing";
				} elseif ($usia_kambing_bulan < 24) {
					$stage = "Remaja";
				} else {
					$stage = "Dewasa";
				}
			@endphp
            
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $goat?->name ?? "-" }}</td>
                <td>{{ $goat?->tag ?? "-" }}</td>
                <td>{{ $goat?->id ?? "-" }}</td>
                <td>{{ $goat?->origin ?? "-" }}</td>
                <td>{{ $goat?->breed ?? "-" }}</td>
                <td>{{ $goat?->gender ?? "-" }}</td>
                <td>{{ $goat?->weight ?? "-" }}</td>
                <td>{{ $goat?->group->name ?? "-" }}</td>
                <td>{{ $stage ?? "-" }}</td>
                <td>{{ $goat?->birth_date->format('d-m-Y') ?? "-" }}</td>
                <td>{{ $goat?->status ?? "-" }}</td>
                <td>{{ $goat?->date_in->format('d-m-Y') ?? "-" }}</td>
                <td>{{ $goat?->user->name ?? '-' }}</td>
            </tr>
                
            @endforeach

		</tbody>
	</table>
 
</body>
</html>
