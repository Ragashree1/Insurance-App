<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyListing;
use Illuminate\Validation\Rule;
use App\Http\Requests\StorePropertyListingRequest;
use App\Http\Requests\UpdatePropertyListingRequest;
use PhpParser\Builder\Property;

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
                'listings' => $listings      
            ]);
    }

    // show single listing
    public function viewListing(int $listing_id)
    {
        // call methods in entity to get array
        $listing = PropertyListing::viewListing($listing_id);

        if($listing)
        {
            return view('listings.viewListing', [
                'listing' => $listing      
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
        
        return view('listings.allListings', ['listings' => $listings]);    
    }

    public function viewListingsCreatedByAgent(int $user_id)
    {
        $listings = PropertyListing::viewListingsCreatedByAgent($user_id);

        return view('listings.manage', [
            'listings' => $listings
        ]);
    }

    //agent search a listing
    public function agentSearchListings(Request $request, int $user_id)
    {
        $searchTerm = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // calling scopeSearchListings of entity class, "scope" is omitted
        $listings = PropertyListing::searchListings($searchTerm, $minPrice, $maxPrice, $user_id);  
        
        return view('listings.manage', ['listings' => $listings]);    
    }

    public function createListing(Request $request, int $user_id)
    {
        $formFields = PropertyListing::validateFormField($request);

        $formFields['create_by'] = $user_id;

        // Store the image file in the 'image' directory under the 'public' disk
        $formFields['image'] = PropertyListing::storeImage($request);

        PropertyListing::createListing($formFields, $user_id);
        return redirect('/listings/manage/' . $user_id);
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
