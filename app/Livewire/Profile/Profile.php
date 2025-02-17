<?php

namespace App\Livewire\Profile;

use App\Models\Profile as ModelsProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class Profile extends Component
{
    use Toast;
    public bool $openProfile = false;
    public $name, $email, $position, $state, $country, $about_me, $number;
    public $profile;
    public $profile_id;

    public function profileclick($profile_id)
    {
        $this->openProfile = true;
        $this->profile_id = $profile_id;
    }
    public function mount($profile_id = null)
    {
        if (!is_null($profile_id)) {
            $this->setValue($profile_id);
        }

        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->position = Auth::user()->position;
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'string',
            'max:255',
            'email' => 'required',
            'string',
            'email',
            'max:255',
            'unique:users,email,' . Auth::id(),
            'position' => 'required',
            'string',
            'max:255',
        ];
    }


    public function setValue($profile_id)
    {

        $this->profile_id = $profile_id;
        $profile = ModelsProfile::where('user_id', $profile_id)->first();
        $this->fill([
            'number' => $profile->number,
            'state' => $profile->state,
            'country' => $profile->country,
            'about_me' => $profile->about_me,
        ]);
    }


    public function create()
    {
        ModelsProfile::create([
            'user_id' => Auth::id(),
            'state' => $this->state,
            'country' => $this->country,
            'about_me' => $this->about_me,
            'number' => $this->number,
        ]);
    }

    public function update()
    {
        ModelsProfile::update([
            'number' => $this->number,
            'state' => $this->state,
            'country' => $this->country,
            'about_me' => $this->about_me,
        ]);
    }

    public function save()
    {
        $this->validate();

        $user = User::where('id', Auth::id())->first();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
        ]);

        if ($this->updating()) {
            $this->update();
            $this->toast(
                type: 'success',
                title: 'Updated!',
                description: ' Profile Updated successfully.',
                position: 'toast-top toast-end',
                icon: 'o-check-circle',
                css: 'alert-success',
            );
        } else {
            $this->create();
            $this->toast(
                type: 'success',
                title: 'Saved!',
                description: ' Profile Saved successfully.',
                position: 'toast-top toast-end',
                icon: 'o-check-circle',
                css: 'alert-success',
            );
        }
        $this->openProfile = false;
    }

    public function render()
    {
        $this->profile_id = Auth::id();
        return view('livewire.profile.profile');
    }
}
