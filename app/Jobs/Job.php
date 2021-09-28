<?php

namespace App\Jobs;

use App\Models\Subscribe;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Job implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use InteractsWithQueue, Queueable, SerializesModels;

    private $websiteID;
    private $postID;
    public function __construct($webID, $post_id)
    {
        $this->websiteID = $webID;
        $this->postID = $post_id;
    }

    public function handle()
    {
        $subscriber = Subscribe::where('website_id', $this->websiteID)->get();
        if ($subscriber){
            foreach ($subscriber as $key){
                $user = User::find($key->user_id);
                if (!$user){
                    throw new \Exception('Invalid user id.');

                } else {
                    $email = $user->email;
                    $postID = $this->postID;
                    Mail::send(['html' => 'emails.post-info'], ['postId' => $postID], function ($message) use ($email) {
                        $message->from('wittegenie@gmail.com', 'Upwork Task');
                        $message->to($email, 'Contact')->subject("New post added in website");
                    });
                }
            }
        }
    }
    
}
