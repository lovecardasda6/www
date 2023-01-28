<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    public function earning_type(){
        return $this->belongsTo(EarningType::class, "earning_type_id");
    }
}
