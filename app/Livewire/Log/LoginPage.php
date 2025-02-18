<?php

namespace App\Livewire\Log;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginPage extends Component
{

    public $email = '';
    public $password = '';

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', 'The provided credentials do not match our records.');
            return redirect()->route('login');
        }

        $user = Auth::user();
        $updatLog = User::where('id', $user->id)->update(['status' => 1]);
        // dd($updatLog);


        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.log.login-page');
    }
}
