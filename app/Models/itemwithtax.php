<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemwithtax extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'tax_id',
    ];
}
