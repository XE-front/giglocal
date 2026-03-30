<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = ['barangay_name'];

    public function gigs()
    {
        return $this->hasMany(Gig::class, 'barangay', 'barangay_name');
    }
}
