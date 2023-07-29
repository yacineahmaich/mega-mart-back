<?php

namespace App\Console\Commands;

use App\Models\Product;
use Database\Seeders\OrderSeeder;
use Illuminate\Console\Command;

class RefreshStoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh-store-data';

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
        Product::restoreProductsQuantity();

        $orderSeeder = new OrderSeeder();
        $orderSeeder->run();
    }
}
