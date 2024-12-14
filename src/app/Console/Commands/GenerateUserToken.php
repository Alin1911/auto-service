<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an access token for a user based on their ID';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
    
        $user = User::find($userId);
    
        if ($user) {
            $token = $user->createToken('Auto')->accessToken;
    
            $this->info('Token generat pentru utilizatorul ' . $user->name . ': ' . $token);
        } else {
            $this->error('Utilizatorul cu ID-ul ' . $userId . ' nu a fost găsit.');
        }
    }
}
