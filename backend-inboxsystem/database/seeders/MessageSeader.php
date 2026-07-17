<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Thread;
use App\Models\Message;

class MessageSeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Thread::all()->each(function ($thread) {
            $participants = $thread->users;

            Message::factory()->count(rand(5,20))->make()->each(function ($message) use ($thread, $participants) {
                $message->thread_id = $thread->id;
                $message->user_id = $participants->random()->id;
                $message->save();
            });
        });
    }
}
