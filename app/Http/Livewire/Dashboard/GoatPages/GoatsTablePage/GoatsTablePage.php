<?php

namespace App\Http\Livewire\Dashboard\GoatPages\GoatsTablePage;

use App\Models\Goat;
use Livewire\WithPagination;
use App\Http\Livewire\Dashboard\_Dashboard;

class GoatsTablePage extends _Dashboard
{
    use WithPagination;

    public $page_title = "Tabel Kambing";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'], ['group', 'Group'], ['status', 'Status'],
        ['breed', 'Breed'], ['gender', 'Sex'], ['tag', 'Tag']
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

            if($page_size >= 40) {
                $page_size = 40;
                $this->page_size = $page_size;
            }

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $goats = Goat::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $goats = Goat::orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['goats'] = $goats;
            $data['user'] = $user;
            $data['pageTitle'] = $this->page_title;

            return view('livewire.dashboard.goat-pages.goats-table-page.goats-table-page', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }
}
