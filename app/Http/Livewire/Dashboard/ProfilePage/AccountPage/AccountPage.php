<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage;

use App\Http\Livewire\Dashboard\_Dashboard;

class AccountPage extends _Dashboard
{
    public $pageTitle = "Akun Saya";

    public $act_page;

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
            'name'  =>  'Edit Profile',
            'key'   =>  'PF87N0',
            'icon'  =>  'edit',
            'path'  =>  'dashboard.profile-page.account-page.components.account-edit',
        ],
        [
            'name'  =>  'Privasi',
            'key'   =>  'SC3RT2',
            'icon'  =>  'unlock',
            'path'  =>  'dashboard.profile-page.account-page.components.account-privacy',
        ],
        [
            'name'  =>  'Pengaturan',
            'key'   =>  'OC920I',
            'icon'  =>  'settings',
            'path'  =>  'dashboard.profile-page.account-page.components.account-config',
        ],
    ];

    public function mount()
    {
        $this->pushBread(1, $this->pageTitle);

        if (request('key') === null)
            $this->act_page = 'AC6X03';
    }

    public function render()
    {
        try {

            $user = auth_user();

            $page['pageTitle'] = $this->pageTitle;

            $data['user']   =   $user;
            $data['posts']  =   [];
            $data['pages']  =   $this->pages;

            return view('livewire.dashboard.profile-page.account-page.account-page', $data)
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