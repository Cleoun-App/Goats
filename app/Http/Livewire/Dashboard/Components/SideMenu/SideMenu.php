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
        return [
            // [
            //     'route' =>  route('ds.home_page'),
            //     'name'  =>  'Home',
            //     'icon'  =>  'home',
            // ],
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
                'route' =>  route('ds.event.types.table'),
                'name'  =>  'Jenis Event',
                'icon'  =>  'list',
            ],
            [
                'route' =>  route('ds.goat.breeds.table'),
                'name'  =>  'Peranakan Kambing',
                'icon'  =>  'list',
            ],
            [
                'route' =>  route('ds.user.mgt.roles'),
                'name'  =>  'Role Pengguna',
                'icon'  =>  'user-check',
            ],
            // [
            //     'name'  =>  'break',
            //     'icon'  =>  null,
            //     'route' =>  null,
            // ],
            [
                'route' =>  route('ds.goats.table'),
                'name'  =>  'Tabel Kambing',
                'icon'  =>  'file-text',
            ],
            [
                'route' =>  route('ds.event.table'),
                'name'  =>  'Tabel Event',
                'icon'  =>  'globe',
            ],
            [
                'route' =>  route('ds.milknote.table'),
                'name'  =>  'Tabel Milknote',
                'icon'  =>  'book',
            ],
        ];
    }
}
