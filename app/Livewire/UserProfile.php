<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class UserProfile extends Component
{
    public $userName;
    public $userEmail;

    public function mount()
    {
        $this->loadUserData();
    }

    #[On('profile-updated')]
    public function refreshProfile()
    {
        $this->loadUserData();
    }

    protected function loadUserData()
    {
        $user = auth()->user();
        $this->userName = $user->name;
        $this->userEmail = $user->email;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
