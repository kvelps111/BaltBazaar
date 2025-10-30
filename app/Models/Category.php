<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

   
    protected $fillable = ['name'];

    
    // category can have many listings
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
