<?php

namespace App\Http\Livewire\Dashboard\MilknotePages\MilknoteTablePage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Models\MilkNote;

class MilknoteTablePage extends _Dashboard
{

    public $page_title = "Tabel Catatan Susu";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'], ['note', 'Catatan'], ['date', 'Tanggal Event'],
        ['produced', 'Produksi'], ['consumption', 'Konsumsi']
    ];

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->defaultSearchAttr("name", "like");
    }
    public function render()
    {
        try {
            
            $user = auth_user();

            $page_size = $this->page_size;

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $milks = MilkNote::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $milks = MilkNote::orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['milks'] = $milks;
            $data['user'] = $user;
            $data['pageTitle'] = $this->page_title;

            return view('livewire.dashboard.milknote-pages.milknote-table-page.milknote-table-page', $data)
                ->layout('layouts.app', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
