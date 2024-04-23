<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    use HasFactory;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = null; 

    protected $fillable = [
        'type',
        'num_bedroom',
        'num_bathroom',
        'area',
        'sale_price',
        'location',
        'description',
        'create_by',
        'seller_id',
        'status',
        'num_views',
        'num_shortlist',
    ];
    
}
