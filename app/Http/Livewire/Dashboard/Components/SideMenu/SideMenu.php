<?php

namespace App\Http\Livewire\Dashboard\Components\SideMenu;

use Livewire\Component;

class SideMenu extends Component
{
    public function render()
    {
        $data['menu'] = $this->getMenu();

        return view('livewire.dashboard.components.side-menu.side-menu', $data);
    }

    protected function getMenu() : array
    {
        $user = auth_user();
        return [
            [
                'route' =>  route('ds.home_page'),
                'name'  =>  'Home',
                'icon'  =>  'home',
            ],
            [
                'route' =>  route('ds.account_page'),
                'name'  =>  'Akun Pengguna',
                'icon'  =>  'trello',
            ],
            [
                'route' =>  route('ds.users.table'),
                'name'  =>  'Tabel Pengguna',
                'icon'  =>  'users',
            ],
            [
                'route' =>  '',
                'name'  =>  'Tabel Kambing',
                'icon'  =>  'file-text',
            ],
            [
                'route' =>  '',
                'name'  =>  'Tabel Event',
                'icon'  =>  'globe',
            ],
            [
                'route' =>  route('ds.user.mgt.roles'),
                'name'  =>  'Role Pengguna',
                'icon'  =>  'user-check',
            ],
            [
                'name'  =>  'break',
                'icon'  =>  null,
                'route' =>  null,
            ],
            [
                'route' =>  '',
                'name'  =>  'Laporang Pengguna',
                'icon'  =>  'book',
            ],
        ];
    }
}
