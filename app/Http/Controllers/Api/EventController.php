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

    public function getEventType(Request $request) {
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

            $user = get_user($request->username);

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

            $user = get_user($request->username);

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

            $user = get_user($request->username);

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
                'data' => ['required', 'string'],
                'date' => ['required', 'date']
            ]);

            $user = get_user($request->username);

            $goat = get_goat($request->goat_tag, false);

            $event = new Event();

            $event->user()->associate($user);

            $event->goat()->associate($goat);

            $event->name = $request->name;
            $event->type = $request->type;
            $event->note = $request->note;
            $event->data = $request->data;
            $event->date = $request->date;

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
                'date' => ['required', 'date']
            ]);

            $user = get_user($request->username);

            $goat = get_goat($request->goat_tag, false);

            $event = $user->events()->find($request->event_id);

            if($event instanceof Event === false) {
                throw new \Exception("Event tidak di-temukan!");
            }

            $event->user()->associate($user);

            $event->goat()->associate($goat);

            $event->name = $request->name;
            $event->type = $request->type;
            $event->note = $request->note;
            $event->data = $request->data;
            $event->date = $request->date;

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
}
