<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sell($quantity)
    {
        $this->available_quantity -= $quantity;
        
        if ($this->available_quantity < 0) {
            $this->available_quantity = 0;
        }
    
        $this->save();
    }
    

}
