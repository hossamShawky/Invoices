<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachments extends Model
{
    public $table="invoice_attachments";
    public $fillable = [];


    public function invoice(){
        return $this->belongsTo("App\Models\Invoice");
    }


}
