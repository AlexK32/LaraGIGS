<?php
 namespace App\Models;

 class Listing {
    public static function all(){
        return[
            [
                'id' => 1,
                'titel' => 'Listings One',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like 
                Aldus PageMaker including versions of Lorem Ipsum.' 
            ],
            [
                'id' => 2,
                'titel' => 'Listings Two',
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like 
                Aldus PageMaker including versions of Lorem Ipsum.' 
            ]
        ];
    }

    public static function find($id) {
        $listings = self::all();

        foreach($listings as $listing) {
            if ($listing['$id'] == $id) {
                return $listing;
            }
        }

    }
 }