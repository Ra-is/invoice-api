<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoice = Invoice::factory(10)->create();
        $items = Item::factory(10)->create(['invoice_id' => $invoice->id]);
    }
}
