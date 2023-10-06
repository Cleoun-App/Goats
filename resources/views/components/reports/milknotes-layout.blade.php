<!DOCTYPE html>
<html>
<head>
	<title>Tabel Milknote</title>
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
        <h2>Goater</h2>
		<h4>Laporan Penyusuan Kambing</h4>
        <h5> {{ now()->format('l d F Y h:i') }} | PDF &middot; Cleoun Render Engine &middot; V1.0.7   </h5>
	</center>

    
    <h2 class="title-sect">Laporan Produksi & Konsumsi</h2>

    <table class='table table-bordered mko-table' style="width: 45%;">
		<thead>
			<tr>
				<th>Milk Note</th>
				<th>Summary</th>
				<th>Average</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">
            
            <tr>
                <td>Produksi</td>
                <td>{{ $milknotes->sum('produced') }} ml</td>
                <td>{{ round($milknotes->average('produced')) }} ml</td>
            </tr>
                
            <tr>
                <td>Konsumsi</td>
                <td>{{ $milknotes->sum('consumption') }} ml</td>
                <td>{{ round($milknotes->average('consumption')) }} ml</td>
            </tr>
            
            <tr>
                <td class="field-sum">Hasil</td>
                <td class="field-sum">{{ $milknotes->sum('produced') - $milknotes->sum('consumption') }} ml</td>
                <td class="field-sum"></td>
            </tr>

		</tbody>
	</table>

	
    <h2 class="title-sect">Laporan Per-Tanggal</h2>

    <table class='table table-bordered mko-table' style="width: 65%;">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Sum_Produksi</th>
				<th>Avg_Produksi</th>
				<th>Sum_Konsumsi</th>
				<th>Avg_Konsumsi</th>
			</tr>
		</thead>
		<tbody style="position: relative; width: 100%">

			@php
				$sum_prod = 0;
				$sum_coms = 0;
				$sum_avg_prod = 0;
				$sum_avg_coms = 0;
			@endphp
            
            @foreach ($averageProductionByDate as $entry)
				@php
					$sum_prod += $entry->summary_production;
					$sum_avg_prod += $entry->average_production;
					$sum_coms += $entry->summary_consumption;
					$sum_avg_coms += $entry->average_consumption;
				@endphp
                <tr>
                    <td>{{ $entry->date->format('D d-m-Y'); }}</td>
					<td>{{ $entry->summary_production }} ml</td>
					<td>{{ $entry->average_production }} ml</td>
                    <td>{{ $entry->summary_consumption }} ml</td>
                    <td>{{ $entry->average_consumption }} ml</td>
                </tr>
            @endforeach
            <tr>
                <td class="field-sum">Total</td>
                <td class="field-sum">{{ $sum_prod }} ml</td>
                <td class="field-sum">{{ round($sum_avg_prod / count($averageProductionByDate)) }} ml</td>
                <td class="field-sum">{{ $sum_coms }} ml</td>
                <td class="field-sum">{{ round($sum_avg_coms / count($averageProductionByDate)) }} ml</td>
            </tr>

		</tbody>
	</table>

    <h2 class="title-sect">Table Records</h2>
 
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
            @foreach ($milknotes->get() as $item)
            
				<tr>
					<td>{{ $loop->index + 1 }}</td>
					<td>{{ $item?->date ?? "-" }}</td>
					<td>{{ $item?->type ?? "-" }}</td>
					<td>{{ $item?->produced ?? "-" }} ml</td>
					<td>{{ $item?->consumption ?? "-" }} ml</td>
					<td>{{ $item?->goats_milked ?? "-" }}</td>
					<td>{{ $item?->goat?->id ?? "-" }}</td>
					<td>{{ $item?->user->name ?? '-' }}</td>
				</tr>
                
            @endforeach
		</tbody>
	</table>
 
</body>
</html>