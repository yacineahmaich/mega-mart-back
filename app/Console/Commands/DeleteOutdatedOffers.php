<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;

class DeleteOutdatedOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-outdated-offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete outdated commands';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Offer::deleteOutdatedOffers();

        $this->info("\"$count\" outdated offers were deleted");

        return Command::SUCCESS;
    }
}
