<?php

/* herd php artisan app:sync-filter-facets */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncFilterFacets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-filter-facets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(\App\Services\FacetSyncService::class)->sync();
        $this->info("Facets synchronized successfully.");
    }
}
