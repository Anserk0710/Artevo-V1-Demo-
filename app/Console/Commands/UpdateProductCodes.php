<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and update product_code for products with null or empty product_code';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Product::whereNull('product_code')
            ->orWhere('product_code', '')
            ->get();

        $count = 0;
        foreach ($products as $product) {
            $product->product_code = strtoupper(uniqid('PRD'));
            $product->save();
            $count++;
        }

        $this->info("Updated product_code for {$count} products.");
    }
}
