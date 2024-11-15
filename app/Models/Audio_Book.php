<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio_Book extends Model
{

    use HasFactory;
    public $fillable = ['name','author','rate','image',
    'path','book_details','category_id'];
    public $timestamps = false;
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
