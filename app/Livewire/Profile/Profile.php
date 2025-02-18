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
    public $name, $email, $position, $state, $country, $about_me, $number, $experience, $projects, $awards;
    public $profile;

    public function profileclick()
    {
        $this->openProfile = true;
    }
    public function mount()
    {
        $this->profile = ModelsProfile::where('user_id', Auth::id())->first();
        // dd($this->profile);
        if ($this->profile) {
            $this->state = $this->profile->state;
            $this->country = $this->profile->country;
            $this->about_me = $this->profile->about_me;
            $this->number = $this->profile->number;
            $this->experience = $this->profile->experience;
            $this->projects = $this->profile->projects;
            $this->awards = $this->profile->awards;
        }
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->position = Auth::user()->position;
    }



    public function updateProfile()
    {
        $profile = ModelsProfile::where('user_id', Auth::id())->first();

        if ($profile) {
            $profile->update([
                'number' => $this->number,
                'state' => $this->state,
                'country' => $this->country,
                'about_me' => $this->about_me,
                'experience' => $this->experience,
                'projects' => $this->projects,
                'awards' => $this->awards,
            ]);
        } else {
            ModelsProfile::create([
                'user_id' => Auth::id(),
                'state' => $this->state,
                'country' => $this->country,
                'about_me' => $this->about_me,
                'number' => $this->number,
                'experience' => $this->experience,
                'projects' => $this->projects,
                'awards' => $this->awards,
            ]);
        }
    }

    public function save()
    {
        $this->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email,' . Auth::id(),
                'position' => 'required|string',
            ]
        );

        $user = User::find(Auth::id());
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'position' => $this->position,
        ]);

        $this->updateProfile();

        $this->toast(
            type: 'success',
            title: 'Saved!',
            description: ' Profile Saved successfully.',
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-success',
        );
        $this->openProfile = false;
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }
}
