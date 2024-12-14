<?php

namespace App\Livewire;

use Livewire\Component;

class WelcomeComponent extends Component
{
    public $message = "Bine ai venit la Service Auto!";

    public function render()
    {
        return view('livewire.welcome-component');
    }

    public function updateMessage()
    {
        $this->message = "Ai apăsat pe buton! Cum te putem ajuta astăzi?";
    }
}
