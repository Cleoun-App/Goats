<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserAccountPage;

use App\Http\Livewire\Dashboard\_Dashboard;

class UserAccountPage extends _Dashboard
{
    public $pageTitle = "Akun Pengguna";

    public $act_page, $username;

    public $queryString = [
        'act_page' => ['as' => 'key',]
    ];

    private $pages = [
        [
            'name'  =>  'Profile Pengguna',
            'key'   =>  'PF87N0',
            'icon'  =>  'edit',
            'path'  =>  'dashboard.profile-page.account-page.components.account-edit',
        ],
        [
            'name'  =>  'Daftar Kambing',
            'key'   =>  'XAMLSJ',
            'icon'  =>  'list',
            'path'  =>  'dashboard.profile-page.account-page.components.goats-table',
        ],
        [
            'name'  =>  'Penyusuan Kambing',
            'key'   =>  'GAUX4O',
            'icon'  =>  'layout',
            'path'  =>  'dashboard.profile-page.account-page.components.milks-table',
        ],
        [
            'name'  =>  'Event Peternakan',
            'key'   =>  'M18SJK',
            'icon'  =>  'globe',
            'path'  =>  'dashboard.profile-page.account-page.components.events-table',
        ],
    ];

    public function mount($username)
    {
        $this->username = $username;

        $this->pushBread(2, $this->pageTitle);

        if (request('key') === null)
            $this->act_page = 'PF87N0';
    }

    public function render()
    {
        try {

            $user = get_user($this->username);

            $page['pageTitle'] = $this->pageTitle;

            $data['user']   =   $user;
            $data['pages']  =   $this->pages;

            return view('livewire.dashboard.user-pages.user-account-page.user-account-page', $data)
                ->layout('layouts.app', $page);

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }

    public function pergi($page_key)
    {
        $this->act_page = $page_key;
    }

}
