<?php

namespace App\Http\Livewire\Dashboard\ProfilePage\AccountPage\Components;

use App\Http\Livewire\Dashboard\DispatchType;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Dashboard\_Dashboard;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\File;
use Livewire\WithFileUploads;
use App\Facades\UserFacade;
use Illuminate\Support\Facades\DB;
use Livewire\TemporaryUploadedFile;
use Spatie\Permission\Models\Role;

class AccountEdit extends _Dashboard
{
    use WithFileUploads;

    public $_username, $username;
    public $name;
    public $photo;
    public $email;
    public $address;
    public $gender;
    public $role;
    public $pp;

    public $ct_fb;
    public $ct_insta;
    public $ct_tweet;

    protected function get_rules(User $user)
    {
        $ignore = Rule::unique('users')->ignore($user->id);

        return [
            'gender' => [
                'required', 'in:male,female',
            ],
            'address' => [
                'string', 'min:3', 'max:120',
            ],
            'username' => [
                'required', 'min:1', 'max:50',
                $ignore,
            ],
            'name' => [
                'required', 'min:4', 'max:180'
            ],
            'email' => [
                'required', 'email', $ignore
            ],
            'role' => [
                'required', 'in:user,admin'
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                File::image()->min(1)->max(3 * 1024),
            ],
        ];
    }

    public function mount($username)
    {
        $this->username = $username;
        $this->_username = $username;

        $user = User::where('username', $username)->firstOrFail();

        $this->name = $user->name;
        $this->pp = $user->image();
        $this->email = $user->email;
        $this->address = $user->address;
        $this->gender = $user->gender;
        $this->role = $user->roles()->first()->name;

        $this->ct_fb = $user ?->contacts['facebook'] ?? '';
        $this->ct_insta = $user ?->contacts['instagram'] ?? '';
        $this->ct_tweet = $user ?->contacts['twitter'] ?? '';
    }

    public function render()
    {
        try {

            return view('livewire.dashboard.profile-page.account-page.components.account-edit');

            // ...
        } catch (\Throwable $th) {
            $this->onRenderError($th);
        }
    }

    /**
     *  Metode update profile
     */
    public function perbahrui()
    {
        try {
            DB::beginTransaction();

            $user = User::where('username', $this->_username)->firstOrFail();

            $rules = $this->get_rules($user);

            $this->validate($rules);

            $filename = $user->profile_photo_path ?? '';

            // upload photo first
            if ($this->photo instanceof TemporaryUploadedFile) {
                $filename = UserFacade::store_photo($user, $this->photo);
                $user->profile_photo = $filename;
            }

            $user->name  =  $this->name;
            $user->username  =  $this->username;
            $user->gender = $this->gender;
            $user->address = $this->address;

            $user->save();

            $role = Role::where('name', $this->role)->firstOrFail();

            if($role instanceof Role) {
                $user->roles()->sync([$role->id]);
            }

            $this->dispatch(DispatchType::Success, [
                'title' => 'Sukses',
                'message' => 'Profil berhasil di update.'
            ]);


            DB::commit();

            // ...
        } catch (ValidationException $ve) {
            DB::rollBack();

            throw $ve;
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->dispatch(DispatchType::Error, [
                'title' => 'Error',
                'message' => $this->filterMessage($th),
            ]);
        }
    }

    public function updateContacts()
    {
        try {

            $user  = User::where('username', $this->username)->firstOrFail();

            $contacts['facebook'] = $this->ct_fb;
            $contacts['twitter'] = $this->ct_tweet;
            $contacts['instagram'] = $this->ct_insta;

            $user->update([
                'contacts' => $contacts
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Sukses',
                'message' => 'Kontak di perbahrui!'
            ]);

            // ...
        } catch (\Throwable $th) {
            return $this->dispatch(DispatchType::Error, [
                'title' => 'Error',
                'message' => $this->filterMessage($th),
            ]);
        }
    }
}
