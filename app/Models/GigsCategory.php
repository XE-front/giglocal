<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GigsCategory extends Model
{
        
    protected $table = 'gigs_categories';

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function gigs()
    {
        return $this->hasMany(Gig::class, 'category_id');
    }
}
