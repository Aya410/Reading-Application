<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{
    use HasFactory;
    public $fillable =['replay','date','user_id','comment_id'];
    public $timestamps = false;
  
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
