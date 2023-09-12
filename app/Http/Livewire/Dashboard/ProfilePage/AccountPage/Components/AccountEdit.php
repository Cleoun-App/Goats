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
use Livewire\TemporaryUploadedFile;

class AccountEdit  extends _Dashboard
{
    use WithFileUploads;

    public $username, $name, $photo, $email, $phone_number;
    public $pp;

    public $ct_fb, $ct_insta, $ct_tweet;

    protected function get_rules(User $user)
    {
        $ignore = Rule::unique('users')->ignore($user->id);

        return [
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
            'phone_number' => [
                'digits_between:8,14', $ignore,
            ],
            'photo' => [
                'nullable',
                'image',
                File::image()
                    ->min(120)
                    ->max(5 * 1024)
                    ->dimensions(Rule::dimensions()->maxWidth(5000)->maxHeight(5000)),
            ],
        ];
    }

    public function mount($username)
    {
        $this->username = $username;

        $user = User::where('username', $username)->firstOrFail();

        $this->name = $user->name;
        $this->pp = $user->image();
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;

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

            $user = User::where('username', $this->username)->firstOrFail();

            $rules = $this->get_rules($user);

            $this->validate($rules);

            $filename = $user->profile_photo_path ?? '';

            if ($this->photo instanceof TemporaryUploadedFile)
                $filename = UserFacade::store_photo($user, $this->photo);

            // upload photo first

            $user->update([
                'name'  =>  $this->name,
                'username'  =>  $this->username,
                'phone_number' => $this->phone_number,
                'profile_photo_path' => $filename,
            ]);

            $this->dispatch(DispatchType::Success, [
                'title' => 'Sukses',
                'message' => 'Profil berhasil di update.'
            ]);

            // ...
        } catch (ValidationException $ve) {
            throw $ve;
        } catch (\Throwable $th) {

            throw $th;

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
