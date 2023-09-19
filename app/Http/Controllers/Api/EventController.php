<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function getEvents(Request $request)
    {
        try {

            $user = get_user($request->username);

            $event = $user->events;

            return ResponseFormatter::success($event, "Event pengguna berhasil di dapatkan");

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

    public function deleteEvent(Request $request) {
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
            
            $user = get_user($request->username);

            $goat = get_goat($request->goat_tag, false);

            $event = new Event();

            $event->user()->associate($user);

            $event->goat()->associate($goat);

            $event->name = $request->name;
            $event->type = $request->type;
            $event->note = $request->note;
            $event->data = $request->data;

            $event->save();

            return ResponseFormatter::success($event, "Event berhasil di-tambahkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }
    

    public function updateEvent(Request $request)
    {
        try {
            
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

            $event->save();

            return ResponseFormatter::success($event, 'Event berhasil di-update');

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }
}
