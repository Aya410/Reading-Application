<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $fillable = ['category_name'];
    public $timestamps = false;
    public function books(){
        return $this->hasMany(Book::class,'categories_id');
    }
    public function audio_book(){
        return $this->hasMany(audio_book::class,'categories_id');
    }
}
