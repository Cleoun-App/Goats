<?php

namespace App\Http\Livewire\Dashboard\Template\TemplateEditPage;

use App\Http\Livewire\Dashboard\_Dashboard;
use App\Http\Livewire\Dashboard\DispatchType;
use App\Http\Livewire\Dashboard\Template\Traits\FileConfigValidation;
use App\Models\Template;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TemplateEditPage extends _Dashboard
{
    use WithFileUploads;
    use FileConfigValidation;

    public $slug;

    public $cover;
    public $_cover;
    public $name;
    public $desc;
    public $price;
    public $tags;
    public $categories;
    public $template_file;
    public $feedbackable = true;
    public $commentable = true;
    public $publicity = true;

    public $config_file;

    public $variables = [];

    public $version;

    public $rules = [
        'cover' => ['required', 'image', 'max:' . 1024 * 2, 'mimes:png,jpg,jpeg,webp'],
        'name' => ['required', 'min:3', 'max:120', 'unique:templates,name'],
        'desc' => ['required', 'min:5', 'max:1250'],
        'price' => ['required', 'regex:/^(?i)Rp\s\d+(\.\d{3})*$/
    ', 'max:10000000'],
        'tags' => ['max:8'],
        'tags.*' => ['min:3', 'max:15'],
        'categories' => ['max:4'],
        'template_file' => ['required', 'file', 'mimes:zip', 'max:' . (1024 * 10), 'min:624'],
        'version' => ['required'],
    ];

    public $_categories = [
        'Formal',
        'Informal',
        'Modern',
        'Clasic',
        'Elegan',
        'Floral',
        'Vintage',
        'Rustic',
        'Minimalis',
        'Monkrom',
        'Colorfull',
        'Spring',
        'Winter',
        'Autum',
        'Culture',
        'Playfull',
        'Sci-fi',
        'Art',
        'Tech',
        'Religion',
    ];

    public function mount($slug)
    {
        $this->slug = $slug;


        $template = Template::getBySlug($slug);

        $this->_cover = $template->coverURL();
        $this->name = $template->name;
        $this->desc = $template->description;
        $this->price = $template->price;
        $this->categories = $template->categories;
        $this->tags = $template->tags;
        $this->variables = array_reverse($template->data);
        $this->version = $template->version;

        if($template->path === "") {
            return;
        }

        $file = new UploadedFile($template->path, '');
        $this->template_file = TemporaryUploadedFile::createFromBase($file);


        // dd($this->template_file->getPath());
    }

    public function updated($prop)
    {
        $this->validateOnly($prop);
    }

    public function render()
    {
        try {
            $page_data['user'] = auth_user();
            $page_data['pageTitle'] = "Add Template";

            return view('livewire.dashboard.template.template-edit-page.template-edit-page')
                ->layout('layouts.app', $page_data);

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);

            // ...
        }
    }

    public function addTag($tag)
    {
        if ($tag == "") {
            return $this->_onError('Tag Tidak Boleh Kosong!');
        }

        $oldTags = $this->tags ?? [];

        $this->tags = array_merge($oldTags, [$tag]);
    }

    public function removeTag($index)
    {
        $c_index = intval($index);

        if ("$c_index" !== $index) {
            return $this->_onError('Index tidak di temukan');
        }

        $tags = $this->tags;

        unset($tags[$c_index]);

        $this->tags = $tags;
    }

    private function _onError($msg)
    {
        return $this->dispatch(DispatchType::Error, ['title' => 'Input Error', 'message' => $msg]);
    }

    public function save()
    {
        $this->validate($this->rules);

        $user = auth_user();

        $creation_mark = md5($this->name . time());

        $store_path = $user->path('templates\\' . $creation_mark);

        $c_path = $this->cover->storeAs($store_path, "cover.webp");

        $path = $this->template_file->storeAs($store_path, "template.zip");

        $template = new Template();

        $template->create([
            'name' => $this->name,
            'cover' => $c_path,
            'path' => $path,
            'description' => $this->desc,
            'slug' => \Str::slug($this->name),
            'price' => trim(str_replace("Rp", '', str_replace('.', "", $this->price))),
            'status' => $this->publicity ? 'public' : 'private',
            'commentable' => var_export($this->commentable, true),
            'feedbackable' => var_export($this->feedbackable, true),
            'tags' => $this->tags,
            'rating' => 0,
            'user_id' => $user->id,
            'data' => $this->variables,
            'version' => $this->version,
            'images' => [],
        ]);

        $this->resetExcept('');

        return $this->dispatch(DispatchType::Success, ['title' => 'Berhasil', 'message' => "Template berhasil di simpan"]);
    }

    private function fakeData()
    {
        $fake_name = ['Neila', 'Beuta', 'Leony', 'Weyds', 'Qiut', 'Voem', 'Lqaktra', 'Jkaoi'];
        $this->name = $fake_name[array_rand($fake_name)];
        $this->desc = fake()->paragraph;
        $this->price = "Rp " .  rand(1000, 100000);
    }

    public function updatedConfigFile(\Livewire\TemporaryUploadedFile $file)
    {
        try {
            $json = \File::get($file->getRealPath());

            $config = json_decode($json, true);

            $this->validateTemplateData($config['data']);

            $this->version  = $config['version'] ?? null;

            $this->variables = $config['data'] ?? [];

            $this->copyright = $config['copyright'] ?? null;

            if(empty($this->version) || empty($this->variables) || empty($this->copyright)) {
                throw new \Exception('Format configurasi tidak sesuai!!');
            }

        } catch (\Throwable $th) {
            $this->dispatch(DispatchType::Error, ['title' => 'Error', 'message' => $th->getMessage()]);
        }
    }

}
