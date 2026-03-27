<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'description',
        'street',
        'barangay',
        'price',
        'price_type',
        'availability',
        'status',
        'post_status',
        'image',
        'rating_avg',
        'total_reviews',
        'completion_count',
        "views_count"
    ];

    protected $casts = [
        'availability' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(GigsCategory::class, 'category_id');
    }
}
