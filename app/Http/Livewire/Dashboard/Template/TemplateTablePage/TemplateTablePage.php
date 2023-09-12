<?php

namespace App\Http\Livewire\Dashboard\Template\TemplateTablePage;

use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;

class TemplateTablePage extends Component
{
    use WithPagination;

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
        $this->search_field = request()->get('search_field', 'name');
        $this->search_operator = request()->get('search_operator', 'like');
    }

    public function render()
    {
        $templates = null;

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

            $templates = Template::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                ->orderBy('created_at', 'DESC')->paginate($this->page_size);
                
        } else {
            $templates = Template::orderBy('created_at', 'DESC')->paginate($this->page_size);
        }

        $data['templates'] = $templates;
        $page_data['pageTitle'] = "Tabel Template";
        $page_data['user'] = auth_user();

        return view('livewire.dashboard.template.template-table-page.template-table-page', $data)
            ->layout('layouts.app', $page_data);
    }

}
