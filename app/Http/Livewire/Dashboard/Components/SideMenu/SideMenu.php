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
            // [
            //     'icon'  =>  'trello',
            //     'name'  =>  'Profil',
            //     'menu'  => [
            //         [
            //             'route' =>  route('ds.account_page'),
            //             'name'  =>  'Akun Saya',
            //             'icon'  =>  'trello',
            //         ],
            //         [
            //             'route' =>  route('ds.user.activities', $user->username),
            //             'name'  =>  'Aktifitas',
            //             'icon'  =>  'activity',
            //         ],
            //     ]
            // ],
            [
                'icon'  =>  'users',
                'name'  =>  'Pengguna',
                'menu'  => [
                    [
                        'route' =>  route('ds.users.table'),
                        'name'  =>  'Tabel Pengguna',
                        'icon'  =>  'users',
                    ],
                    [
                        'route' =>  route('ds.user.create'),
                        'name'  =>  'Tambah Pengguna',
                        'icon'  =>  'user-plus',
                    ],
                ]
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
            // [
            //     'icon'  =>  'lock',
            //     'name'  =>  'Role & Permission',
            //     'menu'  => [
            //         [
            //             'route' =>  route('ds.user.mgt.roles'),
            //             'name'  =>  'Table Roles',
            //             'icon'  =>  'user-check',
            //         ],
            //         [
            //             'route' =>  route('ds.user.mgt.permissions'),
            //             'name'  =>  'Table Permissions',
            //             'icon'  =>  'shield',
            //         ],
            //     ]
            // ],
            // [
            //     'route' =>  route('ds.app.notification'),
            //     'name'  =>  'Notifikasi',
            //     'icon'  =>  'bell',
            // ],
            // [
            //     'name'  =>  'break',
            //     'icon'  =>  null,
            //     'route' =>  null,
            // ],
            // [
            //     'route' =>  route('ds.app.config'),
            //     'name'  =>  'Pengaturan',
            //     'icon'  =>  'settings',
            // ],
            // [
            //     'route' =>  route('ds.app.logger'),
            //     'name'  =>  'Log Aplikasi',
            //     'icon'  =>  'book',
            // ],
        ];
    }
}
