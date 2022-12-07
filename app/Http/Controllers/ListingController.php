<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all Listings
    public function index(Request $request) {
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->get()
        ]);
    }


    // Show single listings 
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }


    // Show create Form
    public function create() {
        return view('listings.create');
    }


    //Store Listig Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings',
            'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required', 
            'description' => 'required'
        ]);

        Listing::create($formFields);


        return redirect('/')->with('message', 'Listing create successfully!');
        // dd($request->all());

    }



}
