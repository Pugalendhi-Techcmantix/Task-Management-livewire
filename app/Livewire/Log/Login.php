<?php

namespace App\Livewire\Log;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{

    public $email = '';
    public $password = '';


    public function login()
    {
        // Validate input
        $this->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        // Attempt authentication
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'The provided credentials do not match our records.');

            return redirect()->route('login');
        }

        // Store user session
        Auth::login(Auth::user());
        $user = Auth::user();

        if ($user instanceof User) { // Ensure $user is an instance of the User model
            $user->status = 1;
            $user->save();
        }
        // Redirect to dashboard after login
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.log.login');
    }
}
