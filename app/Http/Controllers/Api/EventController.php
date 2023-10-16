<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventType;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    public function getEventType(Request $request)
    {
        try {

            $eventType = EventType::get();

            return ResponseFormatter::success($eventType, "Tipe event berhasil di-dapatkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::success([], $th->getMessage());
        }
    }

    public function getEvents(Request $request)
    {
        try {

            $user = auth_user();

            $events = $user->events;

            if(count($events) == 0) {
                throw new \Exception("Pengguna tidak memiliki event");
            }

            return ResponseFormatter::success($events, "Event pengguna berhasil di dapatkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function getEvent(Request $request)
    {
        try {

            $user = auth_user();

            $event = $user->events()->find($request->event_id);

            if($event instanceof Event === false) {
                throw new \Exception("Event tidak tersedia");
            }

            return ResponseFormatter::success($event, "Event berhasil di-dapatkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function deleteEvent(Request $request)
    {
        try {

            $user = auth_user();

            $event = $user->events()->find($request->event_id);

            if($event instanceof Event) {
                $event->delete();

                return ResponseFormatter::success($event, "Event berhasil di-hapus");
            }

            throw new \Exception("Event tidak ditemukan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function addEvent(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:90'],
                'type' => ['required', 'string', 'min:3', 'max:50'],
                'note' => ['required', 'string', 'min:3', 'max:255'],
                'scope' => ['required', 'in:individual,mass'],
                'data' => ['required', 'string'],
                'date' => ['required', 'date']
            ]);

            $user = auth_user();

            $event = new Event();

            $event->user()->associate($user);

            if($request->scope == "individual") {
                $goat = get_goat($request->goat_tag);
                $event->goat()->associate($goat);
            }

            // validasi event field
            if($ev = EventType::where('name', $request->type)->first()) {
                $ev_data = json_decode($request->data);

                foreach($ev_data as $e_data => $v) {
                    if(array_search($e_data, $ev->field) === false) {
                        throw new \Exception("Field $e_data tidak terdaftar di tipe event $ev->name");
                    }
                }
            }

            $event->name = $request->name;
            $event->type = $request->type;
            $event->note = $request->note;
            $event->data = json_decode($request->data);
            $event->date = $request->date;
            $event->scope = $request->scope;

            $event->save();

            return ResponseFormatter::success($event, "Event berhasil di-tambahkan");

            // ...
        } catch (ValidationException $e) {

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }


    public function updateEvent(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'min:3', 'max:90'],
                'type' => ['required', 'string', 'min:3', 'max:50'],
                'note' => ['required', 'string', 'min:3', 'max:255'],
                'data' => ['required', 'string'],
                'scope' => ['required', 'in:individual,mass'],
                'date' => ['required', 'date']
            ]);

            $user = auth_user();

            $event = $user->events()->find($request->event_id);

            if($event instanceof Event === false) {
                throw new \Exception("Event tidak di-temukan!");
            }

            $event->user()->associate($user);

            
            if($request->scope == "individual") {
                $goat = get_goat($request->goat_tag);
                $event->goat()->associate($goat);
            }

            $event->name = $request->name;
            $event->type = $request->type;
            $event->note = $request->note;
            $event->data = json_decode($request->data);
            $event->date = $request->date;
            $event->scope = $request->scope;

            $event->save();

            return ResponseFormatter::success($event, 'Event berhasil di-update');

            // ...
        } catch (ValidationException $e) {

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function getEventsType(Request $request)
    {
        try {
            
            $e_type = strtolower($request->event_type);

            $data = [];

            $user = auth_user();

            $total_goats = $user->goats()->count();

            if($e_type === "pemberatan") {

                $query = $user->events()->where('type', '=', 'Pemberatan')->where('scope', '=', 'individual');;

                $weightened_goats = $query->where('goat_id', '!=', null)->count();

                $data['records'] = $query->get();
                $data['reports'] = [
                    'weightened_goats' => $weightened_goats,
                    'unweightened_goats' => $weightened_goats - $total_goats,
                    'total_goats' => $total_goats,
                ];

            } else if($e_type === "vaksinasi") {

                
                $query = $user->events()->where('type', '=', 'Vaksinasi')->where('scope', '=', 'individual');

                $vaccinated_goats = $query->where('goat_id', '!=', null)->count();

                $data['records'] = $query->get();
                $data['reports'] = [
                    'vaccinated_goats' => $vaccinated_goats,
                    'unvaccinated_goats' => $vaccinated_goats - $total_goats,
                    'total_goats' => $total_goats,
                ];

            } else if ($e_type === "pemerahan") {

                $query = $user->events()->where('type', '=', 'Pemerahan')->where('scope', '=', 'individual');

                $records = $query->get();

                $milk_result = 0;

                foreach($records as $rec) {
                    $result = $rec->data['result'];
                    $milk_result += intval($result);
                }

                $pemerahan_goats = $query->where('goat_id', '!=', null)->count()->where('scope', '=', 'individual');;

                $data['records'] = $records;
                $data['reports'] = [
                    'pemerahan_goats' => $pemerahan_goats,
                    'milk_result' => $milk_result,
                    'total_goats' => $total_goats,
                ];

            } else {

                throw new \Exception("Parameter event_type tidak diketahui!!, hanya menerima pemberatan|vaksinasi|pemerahan");

            }

            return ResponseFormatter::success($data, "Records event $e_type berhasil di-dapatkan!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function getEventTypeReport(Request $req) {
        try {

            $user = auth_user();
            
            $event_type = EventType::all();

            $data = [];
            
            foreach($event_type as $et) {
                $data[$et->name] = $user->events()->where('type', '=', $et->name)->count();
            }

            return ResponseFormatter::success($data, "Laporan event kambing berhasil di-dapatkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }
}
