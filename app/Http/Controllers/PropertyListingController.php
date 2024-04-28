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
        $listing = PropertyListing::findListing($listing_id);

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

        return view('listings.manage', ['listings' => $listings]);
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

    // agent create a listing
    public function createListing(Request $request, int $user_id)
    {
        $formFields = PropertyListing::validateCreateForm($request);

        $formFields['create_by'] = $user_id;

        // Store the image file in the 'image' directory under the 'public' disk
        $formFields['image'] = PropertyListing::storeImage($request);

        $success = PropertyListing::createListing($formFields, $user_id);

        if($success)
        {
            return redirect('/listings/manage/' . $user_id);
        }
        else
        {
            abort('404'); 
        }
        
    }

    // get the listing object that agent chose to update
    public function listingToUpdate(int $listing_id)
    {
        // call methods in entity to get array
        $listing = PropertyListing::findListing($listing_id);

        if($listing)
        {
            return view('listings.updateListing', ['listing' => $listing]);
        }
        else
        {
            abort('404');
        }
    }

    // update the selected listing
    public function updateListing(Request $request, int $listing_id)
    {
        $formFields = PropertyListing::validateUpdateForm($request);

        // Store the image file in the 'image' directory under the 'public' disk
        $formFields['image'] = PropertyListing::storeImage($request);

        $success = PropertyListing::updateListing($formFields, $listing_id);

        if($success)
        {
            return redirect('/listings/manage/' . 2);
        }
        else
        {
            abort('404'); 
        }
    }

    public function deleteListing(int $listing_id)
    {
        $success = PropertyListing::deleteListing($listing_id);
        
        if($success)
        {
            return redirect('/listings/manage/' . 2);
        }
        else
        {
            abort('404'); 
        }
    }
}
