<?php

namespace App\Observers;

use App\Models\Ad;
use Carbon\Carbon;

class AdsObserver
{
    /**
     * Handle the Ads "created" event.
     *
     * @param  \App\Models\Ad  $ads
     * @return void
     */
    public function created(Ad $ad)
    {
        //
    }

    /**
     * Handle the Ads "updated" event.
     *
     * @param  \App\Models\Ad  $ads
     * @return void
     */
    public function updated(Ad $ad)
    {
        if($ad->wasChanged('status') || $ad->wasChanged('admin_approved_influencers')){
            // email has changed
            $ad->update(['status_updated_at' => Carbon::now()]);
        }
    }

    /**
     * Handle the Ads "deleted" event.
     *
     * @param  \App\Models\Ad  $ads
     * @return void
     */
    public function deleted(Ad $ad)
    {
        //
    }

    /**
     * Handle the Ads "restored" event.
     *
     * @param  \App\Models\Ad  $ads
     * @return void
     */
    public function restored(Ad $ad)
    {
        //
    }

    /**
     * Handle the Ads "force deleted" event.
     *
     * @param  \App\Models\Ad  $ads
     * @return void
     */
    public function forceDeleted(Ad $ad)
    {
        //
    }
}
