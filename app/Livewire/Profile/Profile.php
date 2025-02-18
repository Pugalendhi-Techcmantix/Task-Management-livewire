<?php

namespace App\Livewire\Profile;

use App\Models\Profile as ModelsProfile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Profile extends Component
{
    use Toast;
    use WithFileUploads;
    public bool $openProfile = false;
    public $name, $email, $position, $state, $country, $about_me, $number, $experience, $projects, $awards, $photo;
    public $profile;
    public $personal_skills = [],$professional_skills=[];

    protected $listeners = ['refresh-profile' => '$refresh'];

    public function profileclick()
    {
        $this->openProfile = true;
    }
    public function mount()
    {
        $this->profile = ModelsProfile::where('user_id', Auth::id())->first();
        if ($this->profile) {
            $this->state = $this->profile->state;
            $this->country = $this->profile->country;
            $this->about_me = $this->profile->about_me;
            $this->number = $this->profile->number;
            $this->experience = $this->profile->experience;
            $this->projects = $this->profile->projects;
            $this->awards = $this->profile->awards;
            $this->photo = $this->profile->photo;
            $this->personal_skills = json_decode($this->profile->personal_skills, true) ?? [];
            $this->professional_skills = json_decode($this->profile->professional_skills, true) ?? [];
            // dd($this->personal_skills);
        }
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->position = Auth::user()->position;
    }



    public function updateProfile()
    {
        // dd(json_encode($this->professional_skills));
        $profile = ModelsProfile::where('user_id', Auth::id())->first();
        if ($this->photo instanceof UploadedFile) {
            // Store the file in the public disk under 'profile_images' folder
            $photoPath = $this->photo->store('profile_images', 'public');
        } else {
            // If no new file is uploaded, retain the old photo
            $photoPath = $profile ? $profile->photo : null;
        }

        if ($profile) {
            $profile->update([
                'number' => $this->number,
                'state' => $this->state,
                'country' => $this->country,
                'about_me' => $this->about_me,
                'experience' => $this->experience,
                'projects' => $this->projects,
                'awards' => $this->awards,
                'photo' => $photoPath,
                'personal_skills' => json_encode($this->personal_skills),
                'professional_skills' => json_encode($this->professional_skills),
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
                'photo' => $photoPath,
                'personal_skills' => json_encode($this->personal_skills),
                'professional_skills' => json_encode($this->professional_skills),
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
        $this->dispatch('refresh-profile');
        $this->toast(
            type: 'success',
            title: 'Saved!',
            description: ' Profile Saved successfully.',
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-success',
            redirectTo: '/myprofile'
        );
        $this->openProfile = false;
        // Reload the page
        // return redirect()->to(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }
}
