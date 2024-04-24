<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyListing;
use App\Http\Requests\StorePropertyListingRequest;
use App\Http\Requests\UpdatePropertyListingRequest;

class PropertyListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // display all listing
    public function allListings()
    {
        // call method in entity to get array of data
        $listings = PropertyListing::allListings();

        return view('listings.allListings', [
                'listings' => $listings         //array passed to boundary
            ]);
    }

    // show single listing
    public function viewListing(int $id)
    {
        // call methods in entity to get array
        $listing = PropertyListing::viewListing($id);

        if($listing)
        {
            return view('listings.viewListing', [
                'listing' => $listing       // array passed to boundary
            ]);
        }
        else
        {
            abort('404');
        }
    }

    //search a listing
    public function searchListings(Request $request)
    {
        $searchTerm = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // calling scopeSearchListings of entity class, "scope" is omitted
        $listings = PropertyListing::searchListings($searchTerm, $minPrice, $maxPrice);    
        
        return view('listings.allListings', ['listings' => $listings]);         // array passed to boundary
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyListingRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyListing $propertyListing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyListingRequest $request, PropertyListing $propertyListing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyListing $propertyListing)
    {
        //
    }
}
