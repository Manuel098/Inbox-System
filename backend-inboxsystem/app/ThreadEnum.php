<?php

namespace App;

enum ThreadEnum: string
{
    case NEW = 'New';
    case READY = 'Ready';
    case RUNNING = 'Running';
    case WAITING = 'Waiting';
    case TIMED_WAITING = 'Timed Waiting';
    case SLEEP = 'Sleep';
    case TERMINATED = 'Terminated';
}
