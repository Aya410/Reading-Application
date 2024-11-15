<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public $fillable = ['goal','spend_time','date','user_id','status'];
    use HasFactory;
    public $timestamps = false;
    public function users(){
        return $this->belongsTo(User::class);
    }
}
