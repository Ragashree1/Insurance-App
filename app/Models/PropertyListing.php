<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyListing extends Model
{
    use HasFactory;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = null; 

    // make the attributes fillable in database 
    protected $fillable = [
        'type',
        'title',
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

    // display all listings
    public static function allListings(): array
    {
        return static::query()->latest('create_date')->get()->toArray();
    }
    
    // display one listing
    public static function viewListing(int $id): array
    {
        $listings = self::allListings();

        foreach($listings as $listing)
        {
            if($listing['id'] == $id)
            {
                return $listing->toArray();
            }
        }
    }

    public function scopeSearchListings($query, ?string $searchTerm, ?float $minPrice, ?float $maxPrice): array
    {
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('location', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
    
        if ($minPrice) {
            $query->where('sale_price', '>=', $minPrice);
        }
    
        if ($maxPrice) {
            $query->where('sale_price', '<=', $maxPrice);
        }
    
        // Order the results
        $query->latest('create_date');
    
        return $query->get()->toArray();
    }
    
}
