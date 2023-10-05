<?php

namespace App\Http\Livewire\Dashboard;

use App\Exceptions\AppHandler;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

enum DispatchType
{
    case Error;
    case Info;
    case Warn;
    case Success;
}

class _Dashboard extends Component
{
    
    /**
     *  Table Dashboard
     */

    public $search_value;
    public $key;

    public $search_field;
    public $search_operator = 'like';
    
    public $page_size = 5;

    public $search_operators = [
        ['like', 'Sama Dengan'], ['ol29', 'Sama Dengan (Strict)'],  ['dx10', 'Kurang Dari'], ['kl72', 'Lebih Dari'],
        ['nb19', 'Lebih Kecil Sama Dengan'], ['vr05', 'Lebih Besar Sama Dengan'], ['nx00', 'Tidak Sama Dengan']
    ];

    protected $main_roles = [
        'supreme', 'admin', 'user'
    ];

    protected function defaultSearchAttr($field, $opr)
    {
        $this->search_field = $field;
        $this->search_operator = $opr;
    }

    protected function searchOperator()
    {
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
            case "ol29":
                $opr = "=";
                break;
            default:
                $opr = 'like';
        }

        return $opr;
    }

    /**
     *  Table Dashboard
     */

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

    protected function pushBread(int $level, string $title)
    {
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
        if ($th instanceof ValidationException) {
            throw $th;
        }

        throw new AppHandler("[LivewireError]::[Render] " . $th->getMessage(), 100, $th);
    }


    /**
     *  Metode untuk meng-handle error
     */
    protected function onError(\Throwable $th)
    {
        if ($th instanceof ValidationException) {
            throw $th;
        }

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
        if(\config('app.debug') === true) {
            return $th->getMessage();
        }

        return 'Maaf, terjadi kesalahan di dalam sistem kami!';
    }

}
