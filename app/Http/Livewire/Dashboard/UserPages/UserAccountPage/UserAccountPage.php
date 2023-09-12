<?php

namespace App\Http\Livewire\Dashboard\UserPages\UserAccountPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Models\User;

class UserAccountPage extends _Dashboard
{
    public $pageTitle = "Akun Pengguna";

    public $act_page, $username;

    public $queryString = [
        'act_page' => ['as' => 'key',]
    ];

    private $pages = [
        [
            'name'  =>  'Post',
            'key'   =>  'AC6X03',
            'icon'  =>  'file-text',
            'path'  =>  'dashboard.profile-page.account-page.components.my-posts',
        ],
        [
            'name'  =>  'Edit Profile Pengguna',
            'key'   =>  'PF87N0',
            'icon'  =>  'edit',
            'path'  =>  'dashboard.profile-page.account-page.components.account-edit',
        ]
    ];

    public function mount($username)
    {
        $this->username = $username;

        $this->pushBread(2, $this->pageTitle);

        if (request('key') === null)
            $this->act_page = 'AC6X03';
    }

    public function render()
    {
        try {

            $user = User::where('username', $this->username)->firstOrFail();

            $page['pageTitle'] = $this->pageTitle;

            $data['user']   =   $user;
            $data['posts']  =   [];
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
