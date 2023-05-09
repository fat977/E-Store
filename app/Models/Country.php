<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public static function countries(){
        $countries = Country::where('status',1)->get()->toArray();
        return $countries;
    }

}
