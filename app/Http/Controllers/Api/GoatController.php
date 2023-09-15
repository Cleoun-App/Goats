<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goat;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;

class GoatController extends Controller
{

    public function getGoats(Request $request) {
        try {
            
            $user = get_user($request->username);

            $goats = $user->goats;

            return ResponseFormatter::success($goats, 'Data berhasil didapatkan!');

        } catch (\Throwable $th) {
            
            return ResponseFormatter::error([], $th->getMessage());
        }
    }

    public function addGoat(Request $request) {
        try {
            
            $request->validate([
                'name' => ['required', 'min:3', 'max:120'],
                'tag' => ['required', 'alpha_num', 'min:3', 'unique:goats,tag'],
                'picture' => ['min:3', 'max:255'],
                'gender' => ['required', 'in:female,male'],
                'origin' => ['required', 'min:3', 'max:120'],
                'breed' => ['min:3', 'max:120'],
                'status' => ['required', 'in:alive,death,sold'],
                'obtained_by' => ['min:3', 'max:120'],
                'birt_date' => ['string'],
                'note' => ['required', 'min:3', 'max:450']
            ]);

            $user = get_user($request->username);

            $father = get_goat($request->father_tag, false);
            
            $mother = get_goat($request->mother_tag, false);

            $group = get_group($request->group);

            $goat = new Goat();

            $goat->name = $request->name;
            $goat->tag = $request->tag;
            $goat->picture = $request->picture;
            $goat->weight = $request->weight;
            $goat->origin = $request->origin;
            $goat->breed = $request->breed;
            $goat->status = $request->status;
            $goat->obtained_by = $request->obtained_by;
            $goat->birth_date = $request->birth_date;
            $goat->note = $request->note;

            $goat->user()->associate($user);
            $goat->father()->associate($father);
            $goat->mother()->associate($mother);
            $goat->group()->associate($group);

            $goat->save();
            
            return ResponseFormatter::success($goat, "Goat berhasil ditambahkan!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());
        }
    }
}
