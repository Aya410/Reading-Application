<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Now_Reading extends Model
{
    use HasFactory;
    public $fillable = ['user_id','book_id','ratio'];
    public $timestamps = false;
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }


}
