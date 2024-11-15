<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestions extends Model
{
    use HasFactory;
    protected $fillable=['book_name','auther','typecategory','user_id'];
    public $timestamps = false;
    public function users(){
        return $this->belongsTo(User::class);
    }
}
