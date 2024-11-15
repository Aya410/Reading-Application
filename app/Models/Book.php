<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public $fillable = ['book_name','author','rate','image',
                        'path','book_details','last_password_updated','category_id'];
    public $timestamps = false;
    public function category(){
        return $this->belongsTo(Category::class);
    }
   // public function favorites(){
     //   return $this->belongsToMany(User::class,'favorites');
    //}
    public function favorites()
{
    return $this->hasMany(Favorite::class);
}
public function likes()
{
    return $this->hasMany(Like::class);
}
public function quotes()
   {
    return $this->hasMany(Quote::class);
   }
    
   public function comments()
   {
    return $this->hasMany(Comment::class);
   }
   public function replays()
   {
    return $this->hasMany(Replay::class);
   }
}
