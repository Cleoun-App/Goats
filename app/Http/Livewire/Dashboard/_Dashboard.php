<?php

namespace App\Http\Livewire\Dashboard;

use App\Exceptions\AppHandler;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

enum DispatchType{
case Error;
case Info;
case Warn;
case Success;
}

class _Dashboard extends Component
{
    protected $main_roles = [
        'supreme', 'admin', 'customer', 'partner'
    ];

    protected $main_permissions = [

        // Web Page Accessble
        'dashboard.page.enabled',
        'dashboard.config.enabled',
        'dashboard.users.table.enabled',
        'dashboard.users.activity.enabled',
        'dashboard.web.log.enabled',
        'dashboard.notification.enabled',
        'dashboard.templates.table.enabled',
        'dashboard.templates.activity.enabled',
        'dashboard.show.profile.enabled',
        'dashboard.edit.profile.enabled',
        'dashboard.show.account.activity.enabled',

        /**
         *   Web Features Allowed
         */
        

        // (2) user related features
        'dashboard.user.add.enabled',
        'dashboard.user.block.enabled',
        'dashboard.user.remove.enabled',
        'dashboard.user.edit.enabled',

    ];

    protected function pushBread(int $level, string $title) {
        // Session::forget('app_breadcrumb');

        $breadcrumbs = session('app_breadcrumb');

        $breadcrumbs[0] = [
            'url' => '/',
            'name' => 'Dashboard',
        ];

        $breadcrumbs[$level] = [
            'url' => request()->fullUrl(),
            'name' => $title,
        ];

        for($x = $level + 1; $x < count($breadcrumbs); $x++) {
            unset($breadcrumbs[$x]);
        }

        session(['app_breadcrumb' => $breadcrumbs]);
    }

    /**
     *  Metode untuk meng-handle error view
     */
    protected function onRenderError(\Throwable $th)
    {
        if ($th instanceof ValidationException) throw $th;

        throw new AppHandler("[LivewireError]::[Render] " . $th->getMessage(), 100, $th);
    }


    /**
     *  Metode untuk meng-handle error
     */
    protected function onError(\Throwable $th)
    {
        if ($th instanceof ValidationException) throw $th;

        throw new AppHandler("[LivewireError]::[Method] " . $th->getMessage(), 100, $th);
    }


    protected function dispatch(DispatchType $type, array $data)
    {
         if($type == DispatchType::Success) {
            return $this->dispatchBrowserEvent('app.flash.notif', [
                'title' =>  $data['title'] ?? 'Title',
                'message' => $data['message'] ?? 'Example message',
                'timeout' => $data['timeout'] ?? 3500,
                'type' => 'success',
            ]);
        }


         if($type == DispatchType::Error) {
            return $this->dispatchBrowserEvent('app.flash.notif', [
                'title' =>  $data['title'] ?? 'Title',
                'message' => $data['message'] ?? 'Example message',
                'timeout' => $data['timeout'] ?? 15000,
                'type' => 'error',
            ]);
        }
    }


    protected function filterMessage(\Throwable $th): string
    {
         if(\config('app.debug') === true) return $th->getMessage();

        return 'Maaf, terjadi kesalahan di dalam sistem kami!';
    }
}
