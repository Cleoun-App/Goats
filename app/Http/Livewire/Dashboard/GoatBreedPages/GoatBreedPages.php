<?php

namespace App\Http\Livewire\Dashboard\GoatBreedPages;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\Breed;

class GoatBreedPages extends _Dashboard
{
    public $page_title = "Tabel Peranakan Kambing";

    public $queryString = ['search_field', 'search_operator', 'search_value', 'page_size'];

    public $searchable_fields = [
        ['name', 'Nama'],
    ];

    public $breed_name;

    public function mount()
    {
        $this->pushBread(1, $this->page_title);
        $this->defaultSearchAttr("name", "like");
    }

    public function addBreed()
    {
        try {

            $this->validate([
                'breed_name' => 'required|string|min:3|max:30|unique:breeds,name'
            ], [
                'breed_name.unique' => 'Peranakan sudah terdapat dalam basis data!'
            ]);

            $breed = new Breed();

            $breed->name = $this->breed_name;
            $breed->slug = \Str::slug($this->breed_name);

            $breed->save();

            return $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Peranakan ' . $this->breed_name . ' Berhasil ditambahkan',
            ]);

        } catch (\Throwable $th) {

            return $this->dispatch(DispatchType::Error, [
                'title' => 'Terjadi Kesalahan',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        try {

            $user = auth_user();

            $page_size = $this->page_size;

            if($this->search_value != null) {

                $opr = $this->searchOperator();

                $breeds = Breed::where($this->search_field, $opr, $opr == 'like' ? "%{$this->search_value}%" : $this->search_value)
                    ->orderBy('created_at', 'DESC')->paginate($page_size);

            } else {
                $breeds = Breed::orderBy('created_at', 'DESC')->paginate($page_size);
            }

            $data['breeds'] = $breeds;
            $data['user'] = $user;
            $data['pageTitle'] = $this->page_title;

            return view('livewire.dashboard.goat-breed-pages.goat-breed-pages', $data)
                ->layout('layouts.app', $data);

        } catch (\Throwable $th) {

            $this->onRenderError($th);
        }
    }

    public function deleteBreed($id) {
        try {
            
            $breed = Breed::findOrFail($id);

            $breed_name = $breed->name;

            $breed->delete();
            
            return $this->dispatch(DispatchType::Success, [
                'title' => 'Berhasil',
                'message' => 'Peranakan ' . $breed_name . ' berhasil dihapus',
            ]);

            // ...
        } catch (\Throwable $th) {
            
            return $this->dispatch(DispatchType::Error, [
                'title' => 'Terjadi Kesalahan',
                'message' => $th->getMessage(),
            ]);
        }
    }

}
