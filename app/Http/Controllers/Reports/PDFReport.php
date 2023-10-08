<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Goat;
use App\Models\MilkNote;
use App\Utils\ResponseFormatter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFReport extends Controller
{
    public function preview(Request $request)
    {
        $report_model = $request->report_model;

        return match($report_model) {
            "goat" => $this->export_goat($request, true),
            "goats" => $this->export_goats($request, true),
            "events" => $this->export_events($request, true),
            "milk_notes" => $this->export_milk_notes($request, true),
        };
    }

    public function export(Request $request)
    {
        $report_model = $request->report_model;

        return match($report_model) {
            "goat" => $this->export_goat($request),
            "goats" => $this->export_goats($request),
            "events" => $this->export_events($request),
            "milk_notes" => $this->export_milk_notes($request),
        };
    }


    public function export_goat(Request $request, bool $is_preview = false)
    {

        $goat = Goat::find($request->goat_id);

        if($goat instanceof Goat === false) {
            return ResponseFormatter::error([], "Kambing tidak ditemukan!");
        } 

        $data['goat'] = $goat;
        $data['events'] = EventType::all();
        $data['milk_notes'] = $goat->milknote;

        $pdf = Pdf::loadView("components.reports.goat-layout", $data);

        $pdf->setPaper('Legal', 'landscape');

        if($is_preview) {
            return $pdf->stream("goats_report.pdf");
        }

        return $pdf->download("goats_report.pdf");
    }


    public function export_goats(Request $request, bool $is_preview = false)
    {

        try {

            $user = get_user($request->username);

            $goats = $user->goats;

            $data['user'] = $user;

            // ...
        } catch (\Throwable $th) {

            $goats = Goat::all();

            $data['user'] = null;

            // ...
        }

        $data['goats'] = $goats;
        $data['breeds'] = Breed::with('goats')->get();

        $pdf = Pdf::loadView("components.reports.goats-layout", $data);

        $pdf->setPaper('Legal', 'landscape');

        if($is_preview) {
            return $pdf->stream("goats_report.pdf");
        }

        return $pdf->download("goats_report.pdf");
    }

    public function export_events(Request $request, bool $is_preview = false)
    {

        try {
            
            $user = get_user($request->username);

            $data['user_id'] = $user->id;

            // ...
        } catch (\Throwable $th) {

            $data['user_id'] = null;

            // ...
        }

        $data['events'] = EventType::all();

        $pdf = Pdf::loadView("components.reports.events-layout", $data);

        $pdf->setPaper('F4', 'landscape');

        if($is_preview) {
            return $pdf->stream("events_report.pdf");
        }

        return $pdf->download("events_report.pdf");
    }

    public function export_milk_notes(Request $request, bool $is_preview = false)
    {

        try {
            $user = get_user($request->username);

            $milknotes = $user->milknote()->orderBy('date', 'DESC');

            $averageProductionByDate = $user->milknote()->selectRaw('DATE(date) as date')
            ->selectRaw('SUM(produced) as summary_production')
            ->selectRaw('SUM(consumption) as summary_consumption')
            ->selectRaw('FLOOR(AVG(produced)) as average_production')
            ->selectRaw('FLOOR(AVG(consumption)) as average_consumption')
            ->groupBy(DB::raw('DATE(date)'))
            ->orderBy(DB::raw('DATE(date)'))
            ->get();

            // ...
        } catch (\Throwable $th) {

            $milknotes = MilkNote::orderBy('date', 'DESC');

            $averageProductionByDate = MilkNote::selectRaw('DATE(date) as date')
                ->selectRaw('SUM(produced) as summary_production')
                ->selectRaw('SUM(consumption) as summary_consumption')
                ->selectRaw('FLOOR(AVG(produced)) as average_production')
                ->selectRaw('FLOOR(AVG(consumption)) as average_consumption')
                ->groupBy(DB::raw('DATE(date)'))
                ->orderBy(DB::raw('DATE(date)'))
                ->get();
            // ...
        }


        $pdf = Pdf::loadView("components.reports.milknotes-layout", [
            'milknotes' => $milknotes,
            'averageProductionByDate' => $averageProductionByDate,
        ]);

        $pdf->setPaper('F4', 'landscape');

        if($is_preview) {
            return $pdf->stream("milk_notes_report.pdf");
        }

        return $pdf->download("milk_notes_report.pdf");
    }
}
