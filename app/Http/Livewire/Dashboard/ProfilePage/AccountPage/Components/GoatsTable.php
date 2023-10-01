<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\_Dashboard;
use Livewire\WithPagination;

class GoatsTable extends _Dashboard
{
    use WithPagination;

    public $username;

    public $page_title = "Daftar Kambing Pengguna";

    public $search_field = 'name';
    public $search_operator = 'like';
    public $search_value;
    public $key;

    public $queryString = ['search_field', 'search_operator', 'search_value', 'key'];

    public $searchable_fields = [
        ['name', 'Nama'], ['group', 'Group'], ['status', 'Status'],
        ['breed', 'Breed'], ['gender', 'Kelamin'], ['tag', 'Tag']
    ];

    public $search_operators = [
        ['like', 'Sama Dengan'],  ['dx10', 'Kurang Dari'], ['kl72', 'Lebih Dari'],
        ['nb19', 'Lebih Kecil Sama Dengan'], ['vr05', 'Lebih Besar Sama Dengan'], ['nx00', 'Tidak Sama Dengan']
    ];

    public function mount(string $username)
    {
        $this->pushBread(1, $this->page_title);
        $this->search_field = request()->get('search_field', 'name');
        $this->search_operator = request()->get('search_operator', 'like');
    }

    public function render()
    {
        try {
            $user = get_user($this->username);

            $page_size = 5;

            if($page_size >= 40) {
                $page_size = 40;
            }

            if($this->search_value != null) {

                $opr = null;

                switch($this->search_operator) {
                    case "dx10":
                        $opr = "<";
                        break;
                    case "kl72":
                        $opr = ">";
                        break;
                    case "nb19":
                        $opr = "<=";
                        break;
                    case "vr05":
                        $opr = ">=";
                        break;
                    case "nx00":
                        $opr = "!=";
                        break;
                    default:
                        $opr = 'like';
                }

                $goats = $user->goats()->where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $goats = $user->goats()->orderBy('created_at', 'DESC')->paginate($page_size);
            }


            $data['goats'] = $goats;
            $data['user'] = $user;

            return view('livewire.dashboard.profile-page.account-page.components.goats-table', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
