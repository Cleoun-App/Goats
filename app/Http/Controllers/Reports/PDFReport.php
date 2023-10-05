<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Breed;
use App\Models\Event;
use App\Models\Goat;
use App\Models\MilkNote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFReport extends Controller
{

    public function preview(Request $request) {
        $report_model = $request->report_model; 

        return match($report_model) {
            "goats" => $this->export_goats($request, true),
            "events" => $this->export_events($request, true),
            "milk_notes" => $this->export_milk_notes($request, true),
        };
    }

    public function export(Request $request) {
        $report_model = $request->report_model; 

        return match($report_model) {
            "goats" => $this->export_goats($request),
            "events" => $this->export_events($request),
            "milk_notes" => $this->export_milk_notes($request),
        };
    }

    public function export_goats(Request $request, bool $is_preview = false)
    {

        $user = get_user($request->username);

        try {

            $goats = $user->goats;

            // ...
        } catch (\Throwable $th) {

            $goats = Goat::all();

            // ...
        }

        $data['user'] = $user;
        $data['goats'] = $goats;
        $data['breeds'] = Breed::with('goats')->get();

        $pdf = Pdf::loadView("components.reports.goats-layout", $data);

        $pdf->setPaper('A4', 'landscape');

        if($is_preview) {
            return $pdf->stream("goats_report.pdf");
        }
        
        return $pdf->download("goats_report.pdf");
    }
    
    public function export_events(Request $request, bool $is_preview = false)
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

        if($is_preview) {
            return $pdf->stream("events_report.pdf");
        }
        
        return $pdf->download("events_report.pdf");
    }
    
    public function export_milk_notes(Request $request, bool $is_preview = false)
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

        if($is_preview) {
            return $pdf->stream("milk_notes_report.pdf");
        }
        
        return $pdf->download("milk_notes_report.pdf");
    }
}
