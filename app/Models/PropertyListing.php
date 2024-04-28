<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'image'
    ];

    // display all listings
    public static function allListings(): array
    {
        return static::query()->latest('create_date')->get()->toArray();
    }
    
    // display one listing
    public static function findListing(int $listing_id): array
    {
        // Find the listing with the given ID
        $listing = self::where('id', $listing_id)->first();

        if ($listing) {
            return $listing->toArray();
        }

        // If no matching listing is found, return an empty array
        return [];
    }


    // search listings 
    public function scopeSearchListings($query, ?string $searchTerm, ?float $minPrice, ?float $maxPrice, ?int $user_id = null): array
    {
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('location', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($user_id) {
            $query->where('create_by', $user_id);
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

    // view all listings created by agent
    public static function viewListingsCreatedByAgent(int $user_id): array
    {
        // Assuming your model has a 'user_id' column to store the agent's ID
        $listings = self::where('create_by', $user_id)->get()->toArray();

        return $listings;
    }

    // store image in the public folder
    public static function storeImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();
            return $request->file('image')->storeAs('images', $imageName, 'public');
        }
    
        return null; // Return null if no image is uploaded
    }
    

    public static function validateCreateForm(Request $request): array
    {
        $formFields = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'num_bedroom' => 'required|numeric|min:0',
            'num_bathroom' => 'required|numeric|min:0',
            'area' => 'required|numeric|gt:0',
            'sale_price' => 'required|numeric|gt:0',
            'status' => 'required',
            'location' => [
                'required',
                Rule::unique('property_listings', 'location'),
            ],
            'description' => 'required',
            'seller_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('user_profile_id', 3);
                }),
            ],
        ]);

        return $formFields;
    }

    public static function validateUpdateForm(Request $request): array
    {
        $formFields = $request->validate([
            'title' => 'required',
            'type' => 'required',
            'num_bedroom' => 'required|numeric|min:0',
            'num_bathroom' => 'required|numeric|min:0',
            'area' => 'required|numeric|gt:0',
            'sale_price' => 'required|numeric|gt:0',
            'status' => 'required',
            'location' => 'required',
            'description' => 'required',
            'seller_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('user_profile_id', 3);
                }),
            ],
        ]);

        return $formFields;
    }

    public static function createListing(array $formData, int $user_id): bool
    {
        try {
            // create the form
            self::create($formData);
            return true; 
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false; 
        }
    }

    // updating a listing
    public static function updateListing(array $formData, int $listing_id): bool
    {
        // Find the listing with the given ID
        $listing = self::where('id', $listing_id)->first();

        try {
            // create the form
            $listing->update($formData);
            return true; 
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false; 
        }
    }

    public static function deleteListing(int $listing_id): bool
    {
        $listing = self::where('id', $listing_id)->first();

        try {
            $listing->delete();
            return true;
            
        } catch (\Exception $e) {
            return false;
        }
    }

    
}
