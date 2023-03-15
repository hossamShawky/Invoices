<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $table = "sections";
   protected $fillable = [
        "section_name",
        "description",
        "created_by"
    ];

public function products(){
    return $this->hasMany("App\Models\Product");
}


public function invoices(){
    return $this->hasMany("App\Models\Invoice");
}

}


