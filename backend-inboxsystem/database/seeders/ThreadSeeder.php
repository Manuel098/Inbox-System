<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Thread;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Thread::factory()->count(20)->create()->each(function ($thread) use ($users) {
            $participants = $users->random(rand(2,4));
            foreach ($participants as $user) {
                $thread->users()->attach($user->id, [ 'last_read_at' => now() ]);
            }
        });
    }
}
