<?php

namespace App\Listeners;

use App\Events\VoluumEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Voluum\Influencer;
use App\Voluum\Offer;
use Illuminate\Support\Facades\Log;
use App\Jobs\VoluumJob;


class VoluumListener implements ShouldQueue
{
    use InteractsWithQueue;

     /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection = 'database';
 
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';
 
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 0;


    public $afterCommit = true;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
        Log::info('Listener Fired.');
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\VoluumEvent  $event
     * @return void
     */
    public function handle(VoluumEvent $event)
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path().'/logs/vlouum.log',
        ])->error('Event called now');
        if($event->type == 'influencer'){
            $voluum = new Influencer;
            $voluum->addInfluencer($event->modelId);
        }else if($event->type == 'offer'){
            $voluum = new Offer;
            $voluum->createOffer($event->modelId);
        }else if($event->type == 'campaign'){
            $voluum = new Campaign;
            $voluum->createCampaign($event->modelId);
        }
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\VoluumEvent  $event
     * @return bool
     */
    public function shouldQueue(VoluumEvent $event)
    {
        return true;
    }
}
