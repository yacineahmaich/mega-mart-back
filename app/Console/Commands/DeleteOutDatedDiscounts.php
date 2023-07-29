<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class DeleteOutDatedDiscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-outdated-discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete outdated discounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Discount::deleteOutdetedDiscounts();

        $this->info("\"$count\" outdated discounts were deleted");

        return Command::SUCCESS;
    }
}
