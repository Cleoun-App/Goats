<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Utils\ResponseFormatter;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getGroups(Request $request)
    {
        try {

            $user = auth_user();

            $group = $user->group;

            if(count($group) <= 0) {
                throw new \Exception("Pengguna belum membuat group");
            }

            return ResponseFormatter::success($group, "Group pengguna berhasil di dapatkan!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function addGroup(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'min:3', 'max:120']
            ]);

            $user = auth_user();

            $group = new Group();

            $group->name = $request->name;

            $group->slug = md5($user->id . $request->name);

            $group->user()->associate($user);

            $group->save();

            return ResponseFormatter::success($group, "Group $request->name berhasil di-tambahkan");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function editGroup(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'min:3', 'max:120']
            ]);

            $user = auth_user();

            $group = Group::find($request->group_id);

            if($group instanceof Group === false) {
                throw new \Exception("Group tidak ditemukan!");
            }

            $group->name = $request->name;

            $group->slug = md5($user->id . $request->name);

            $group->user()->associate($user);

            $group->save();

            return ResponseFormatter::success($group, "Group $request->name berhasil di-update");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }

    public function deleteGroup(Request $request)
    {
        try {

            $user = auth_user();

            $group = $user->group()->find($request->group_id);

            if($group instanceof Group === false) {
                throw new \Exception("Group tidak ditemukan!");
            }

            $name = $group->name;

            $group->delete();

            return ResponseFormatter::success($group, "Group $name berhasil dihapus!");

            // ...
        } catch (\Throwable $th) {

            return ResponseFormatter::error([], $th->getMessage());

            // ...
        }
    }
}
