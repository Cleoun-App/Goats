<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserTablePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Livewire\WithPagination;

class UserTablePage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Tabel Pengguna";

    public $search_field = 'name';
    public $search_operator = 'like';
    public $search_value;

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $page_size = 10;

    public $searchable_fields = [
        ['name', 'Nama'], ['price', 'Harga'], ['status', 'Status'],
        ['rating', 'Rating'], ['description', 'Deskripsi'], ['tags', 'Tags']
    ];

    public $search_operators = [
        ['like', 'Sama Dengan'],  ['dx10', 'Kurang Dari'], ['kl72', 'Lebih Dari'],
        ['nb19', 'Lebih Kecil Sama Dengan'], ['vr05', 'Lebih Besar Sama Dengan'], ['nx00', 'Tidak Sama Dengan']
    ];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->search_field = request()->get('search_field', 'name');
        $this->search_operator = request()->get('search_operator', 'like');
    }

    public function render()
    {

        $page_size = $this->page_size;

        if($page_size >= 40) {
            $page_size = 40;
            $this->page_size = $page_size;
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

            $users = User::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                ->orderBy('created_at', 'DESC')->paginate($this->page_size);

        } else {
            $users = User::orderBy('created_at', 'DESC')->paginate($this->page_size);
        }

        $data['users'] = $users;
        $data['pageTitle'] = "Tabel Pengguna";
        $data['user'] = auth_user();

        return view('livewire.dashboard.user-pages.user-table-page.user-table-page', $data)
            ->layout('layouts.app', $data);
    }

    public function deleteUser($id)
    {
        try {

            $user = User::findOrFail($id);

            $roles = $user->roles()->where('name','admin')->count();

            $user->delete();

            return $this->dispatch(DispatchType::Success, [
                 'title' => 'Berhasil',
                 'message' => 'User berhasil di hapus'
             ]);

        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, [
                'title' => 'Gagal',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
