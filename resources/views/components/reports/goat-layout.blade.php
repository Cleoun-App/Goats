<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }} - Laporan Kambing</title>
    <style type="text/css">
        body,
        * {
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
        table tr th {
            text-align: center;
            font-size: 9pt;
            margin: 0;
        }

        table tr th {
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
        
        tbody tr td {
            font-weight: 700;
            text-transform: uppercase;
         }
    </style>
</head>

<body style="position: relative">
    <center class="header">
        <h2>{{ config('app.name') }}</h2>
        <h4>Laporan Data Kambing</h4>
        <h5> {{ now()->format('D d-m-Y') }} | PDF &middot; Cleoun Render Engine &middot; V1.0.7 </h5>
    </center>


    <h2 class="title-sect">DETAIL KAMBING</h2>

    <table class='table table-bordered mko-table' style="width: 55%; position: relative; margin: auto">
        <thead>
            <tr>
                <th>Data Kambing</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody style="position: relative; width: 100%">

            @php
                // Tanggal lahir kambing (gantilah dengan tanggal lahir sebenarnya yang Anda kirim dari kontroler).
                $tanggal_lahir = $goat->birth_date;
                
                // Hitung usia kambing dalam bulan
                $usia_kambing_bulan = $tanggal_lahir->diffInMonths(now());
                
                // Definisikan tahap berdasarkan usia
                if ($usia_kambing_bulan < 6) {
                    $stage = 'Bayi';
                } elseif ($usia_kambing_bulan < 12) {
                    $stage = 'Anak Kambing';
                } elseif ($usia_kambing_bulan < 24) {
                    $stage = 'Remaja';
                } else {
                    $stage = 'Dewasa';
                }
            @endphp

            <tr>
                <td>ID</td>
                <td>{{ $goat->id }}</td>
            </tr>

            <tr>
                <td>Nama</td>
                <td>{{ $goat->name }}</td>
            </tr>

            <tr>
                <td>Tag</td>
                <td>{{ $goat->tag }}</td>
            </tr>

            <tr>
                <td>Asal</td>
                <td>{{ $goat->origin }}</td>
            </tr>

            <tr>
                <td>Pemilik</td>
                <td>{{ $goat?->user->name ?? '-' }}</td>
            </tr>

            <tr>
                <td>Breed/Jenis</td>
                <td>{{ $goat?->breed ?? '-' }}</td>
            </tr>

            <tr>
                <td>Gender</td>
                <td>{{ $goat?->gender ?? '-' }}</td>
            </tr>

            <tr>
                <td>Weight</td>
                <td>{{ $goat?->weight ?? '-' }} gram</td>
            </tr>

            <tr>
                <td>Group</td>
                <td>{{ $goat?->group->name ?? '-' }}</td>
            </tr>

            <tr>
                <td>Stage/Usia</td>
                <td>{{ $stage ?? '-' }}</td>
            </tr>

            <tr>
                <td>Tanggal Lahir</td>
                <td>{{ $goat?->birth_date->format('d-m-Y') ?? '-' }}</td>
            </tr>

            <tr>
                <td>Status</td>
                <td>{{ $goat?->status ?? '-' }}</td>
            </tr>

            <tr>
                <td>Tanggal Masuk</td>
                <td>{{ $goat?->date_in->format('d-m-Y') ?? '-' }}</td>
            </tr>

            <tr>
                <td class="field-sum"> </td>
            </tr>

        </tbody>
    </table>

    
    <h2 class="title-sect">Produksi & Konsumsi Kambing</h2>

    <table class='table table-bordered mko-table' style="width: 40%; margin: auto;">

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
                <td>{{ $goat->milknote->sum('produced') }} ml</td>
                <td>{{ round($goat->milknote->average('produced')) }} ml</td>
            </tr>
                
            <tr>
                <td>Konsumsi</td>
                <td>{{ $goat->milknote->sum('consumption') }} ml</td>
                <td>{{ round($goat->milknote->average('consumption')) }} ml</td>
            </tr>
            
            <tr>
                <td class="field-sum">Hasil</td>
                <td class="field-sum">{{ $goat->milknote->sum('produced') - $goat->milknote->sum('consumption') }} ml</td>
                <td class="field-sum"></td>
            </tr>

		</tbody>

	</table>
    
    <hr style="margin-bottom: 50px">
    
    <h2 class="title-sect">CATATAN INDIVIDUAL EVENTS</h2>

	@foreach ($events as $etype)

    @php
        $event_types = $etype->events()->where("goat_id", "=", $goat->id)->get();
    @endphp

    @if (count($event_types) > 0)

        <h4 class="title-sect">Tabel Event {{ $etype->name }}</h4>

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
        
    @endif

@endforeach


</body>

</html>
