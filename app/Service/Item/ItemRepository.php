<?php

namespace App\Service\Item;

use App\Models\Item;

class ItemRepository
{
    public function create($data)
    {
        return Item::create($data);
    }
    public function get($id)
    {
        return Item::where('invoice_item_id', $id)->latest()->first();
    }
}
