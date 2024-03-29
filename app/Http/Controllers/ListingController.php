<?php

namespace App\Http\Controllers;


use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all Listings
    public function index() {
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag', 'search']))->paginate(6)
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

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logo', 
            'public');
        }

        $formFields['user_id'] = auth()->id(); 

        Listing::create($formFields);


        return redirect('/')->with('message', 
        'Listing create successfully!');
    }

    //Show Edit Form
    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

     //Update Listig Data
     public function update(Request $request, Listing $listing) {
        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required', 
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logo', 
            'public');
        }

        $listing->update($formFields);


        return back()->with('message', 'Listing update successfully!');
    }

    //Delete Listing
    public function destroy(Listing $listing) {
        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted succesfully');
    }

    //Manage Listing
    public function manage() {
        return view('listings.manage', ['listings' => auth()
        ->user()->listings()->get()]);
    }
}
