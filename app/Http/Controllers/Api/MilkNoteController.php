<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MilkNote;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class MilkNoteController extends Controller
{
    public function addNote(Request $request)
    {
        try {
            $request->validate([
                'date' => ['required', 'date'],
                'type' => ['required', 'in:individual,bulk'],
                'produced' => ['required', 'integer', 'between:1,999999'],
                'consumption' => ['required', 'integer', 'between:1,999999'] ,
                'goats_milked' => ['required', 'integer', 'between:1,99999'],
                'goat_tag' => ['string'],
            ]);

            $user = get_user($request->username);

            $goat = get_goat($request->goat_tag, false);

            $note = new MilkNote();

            $carbon = Carbon::createFromFormat("Y-m-d",$request->date);

            $note->date = $carbon;
            $note->type = $request->type;
            $note->produced = $request->produced;
            $note->consumption = $request->consumption;
            $note->goats_milked = $request->goats_milked;

            $note->user()->associate($user);
            $note->goat()->associate($goat);

            $note->save();

            return ResponseFormatter::success($note, 'Catatan berhasil ditambahkan');

            // ...
        } catch (ValidationException $e){

            return ResponseFormatter::validasiError($e);

        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function updateNote(Request $request)
    {
        try {
            $request->validate([
                'date' => ['required', 'date'],
                'type' => ['required', 'in:individual,bulk'],
                'produced' => ['required', 'integer', 'between:1,999999'],
                'consumption' => ['required', 'integer', 'between:1,999999'] ,
                'goats_milked' => ['required', 'integer', 'between:1,99999'],
                'goat_tag' => ['string'],
            ]);

            $user = get_user($request->username);

            $goat = get_goat($request->goat_tag, false);

            $note = new MilkNote();

            $carbon = Carbon::createFromFormat("Y-m-d",$request->date);

            $note->date = $carbon;
            $note->type = $request->type;
            $note->produced = $request->produced;
            $note->consumption = $request->consumption;
            $note->goats_milked = $request->goats_milked;

            $note->user()->associate($user);
            $note->goat()->associate($goat);

            $note->save();

            return ResponseFormatter::success($note, 'Catatan berhasil ditambahkan');

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
            // ...
        }
    }

    public function getNote(Request $request)
    {
        try {

            $user = get_user($request->username);

            $milknote = $user->milknote()->find($request->note_id) ?? [];

            if(count($milknote) === 0) 
                throw new \Exception('Catatan susu tidak ditemukan!');

            return ResponseFormatter::success($milknote, 'Catatan susu berhasil didapatkan');

            // ...
        } catch (\Throwable $th) {
            
            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }
    
    public function getNotes(Request $request)
    {
        try {

            $user = get_user($request->username);

            $milknote = $user->milknote;

            if(count($milknote) === 0) 
                throw new \Exception('Catatan susu tidak ditemukan!');

            return ResponseFormatter::success($milknote, 'Catatan susu berhasil didapatkan');

            // ...
        } catch (\Throwable $th) {
            
            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function deleteNote(Request $request) {
        try {

            $user = get_user($request->username);

            $milknote = $user->milknote()->find($request->id);

            if($milknote instanceof MilkNote === false) 
                throw new \Exception('Catatan susu tidak ditemukan!');

            $milknote->delete();

            return ResponseFormatter::success($milknote, 'Catatan susu berhasil dihapus');

            // ...
        } catch (\Throwable $th) {
            
            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }
}
