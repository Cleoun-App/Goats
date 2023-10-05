<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Goat;
use App\Models\MilkNote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFReport extends Controller
{

    public function export(Request $request) {
        $report_model = $request->report_model; 

        return match($report_model) {
            "goats" => $this->export_goats($request),
            "events" => $this->export_events($request),
            "milk_notes" => $this->export_milk_notes($request),
        };
    }

    public function export_goats(Request $request)
    {

        try {

            $goats = get_user($request->username)->goats;

            // ...
        } catch (\Throwable $th) {

            $goats = Goat::all();

            // ...
        }

        $pdf = Pdf::loadView("components.reports.goats-layout", [ 'goats' => $goats ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream("goats_report.pdf");
    }
    
    public function export_events(Request $request)
    {

        try {

            $events = get_user($request->username)->events()->orderBy('date', 'DESC')->get();

            // ...
        } catch (\Throwable $th) {

            $events = Event::orderBy('date', 'DESC')->get();

            // ...
        }

        $pdf = Pdf::loadView("components.reports.events-layout", [ 'events' => $events ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream("events_report.pdf");
    }
    
    public function export_milk_notes(Request $request)
    {

        try {

            $milknotes = get_user($request->username)->milknote()->orderBy('date', 'DESC')->get();

            // ...
        } catch (\Throwable $th) {

            $milknotes = MilkNote::orderBy('date', 'DESC')->get();

            // ...
        }

        $pdf = Pdf::loadView("components.reports.milknotes-layout", [ 'milknotes' => $milknotes ]);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream("milk_notes_report.pdf");
    }
}
