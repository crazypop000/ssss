<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Tool extends Model
{
    protected $fillable = ['name', 'user_id', 'quantity', 'description'];

    public function user() 
    {
    	return $this->belongsTo(User::class);
    }
}
