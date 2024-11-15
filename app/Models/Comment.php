<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $fillable =['comment','date','user_id','book_id'];
    public $timestamps = false;
   
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public function replay(){
        return $this->hasMany(Replay::class);
    }
}
