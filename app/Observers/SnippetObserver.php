<?php

namespace App\Observers;

use App\Models\Snippet;

class SnippetObserver
{
    /**
     * Handle the Snippet "created" event.
     *
     * @param  \App\Models\Snippet  $snippet
     * @return void
     */
    public function created(Snippet $snippet)
    {
        if ($snippet->steps()->count() === 0) {
            $snippet->steps()->create([
                'title' => 'Untitled Step',
                'order' => 1
            ]);
        }
        return;
    }

    /**
     * Handle the Snippet "updated" event.
     *
     * @param  \App\Models\Snippet  $snippet
     * @return void
     */
    public function updated(Snippet $snippet)
    {
        //
    }

    /**
     * Handle the Snippet "deleted" event.
     *
     * @param  \App\Models\Snippet  $snippet
     * @return void
     */
    public function deleted(Snippet $snippet)
    {
        //
    }

    /**
     * Handle the Snippet "restored" event.
     *
     * @param  \App\Models\Snippet  $snippet
     * @return void
     */
    public function restored(Snippet $snippet)
    {
        //
    }

    /**
     * Handle the Snippet "force deleted" event.
     *
     * @param  \App\Models\Snippet  $snippet
     * @return void
     */
    public function forceDeleted(Snippet $snippet)
    {
        //
    }
}
