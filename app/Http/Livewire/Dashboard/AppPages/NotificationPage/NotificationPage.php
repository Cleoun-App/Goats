<?php

namespace App\Http\Livewire\Dashboard\AppPages\NotificationPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use Livewire\WithPagination;

class NotificationPage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Notifikasi Pengguna";

    public $active_section;

    public $search;

    public $section_pages = [
        [
            "key" => "new",
            "name" => "Baru",
            "icon" => "mail",
        ],
        [
            "key" => "inbox",
            "name" => "Inbox",
            "icon" => "mail",
        ],
        [
            "key" => "important",
            "name" => "Penting",
            "icon" => "tag",
        ],
        [
            "key" => "trash",
            "name" => "Sampah",
            "icon" => "trash",
        ]
    ];

    public $queryString = ['active_section', 'search'];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        if($this->active_section == null) {
            $this->active_section = 'new';
        }
    }

    public function render()
    {
        $user = auth_user();

        $data['pageTitle'] = $this->page_title;
        $data['user'] = $user;
        $data['c_new'] = $user->unreadNotifications()->count();
        $data['c_inbox'] = $user->notifications()->count();
        $data['c_important'] = $user->notifications()->where('type', 'important')->count();
        $data['c_trash'] = 0;

        switch($this->active_section) {
            case "new":
                $data['notifs'] = $user->unreadNotifications()->where('data', "LIKE", "%{$this->search}%")->paginate(10);
                break;
            case "trash":
                $data['notifs'] = $user->notifications()->where('data', "LIKE", "%{$this->search}%")->paginate(10);
                break;
            case "important":
                $data['notifs'] = $user->notifications()->where('type', 'important')->paginate(10);
                break;
            default:
                $data['notifs'] = $user->notifications()->where('data', "LIKE", "%{$this->search}%")->paginate(10);
                break;
        }

        return view('livewire.dashboard.app-pages.notification-page.notification-page', $data)
        ->layout('layouts.app', $data);
    }

    public function changeSection($key)
    {
        $this->active_section = $key;
    }

    public function freshUp()
    {
        sleep(2);
    }

    public function dlx($id)
    {
        try {

            $user = auth_user();
            $notif = $user->notifications()->findOrFail($id);
            $notif->delete();

            $this->dispatch(DispatchType::Success, [
                'title' => "Success",
                'message' => "Notifikasi Berhasil Dihapus",
            ]);
        } catch (\Throwable $th) {

            $this->dispatch(DispatchType::Error, [
                'title' => 'Error',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
