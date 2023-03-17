<?php

namespace App\Console\Commands;

use App\Mail\SubscribeMailMarkdown;
use App\Models\subscribe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class subscribeexpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscribe:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe every weekly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        $message = "Visit our website ('Couture Sofa') for a range of new products";
        $subscribers = subscribe::get();
        foreach($subscribers as $subscribe){
            Mail::to($subscribe->email)->send(new SubscribeMailMarkdown($message));
        }
    }
}
