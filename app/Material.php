<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\ImportExport;

class Material extends Model
{
    public function user() 
    {
    	return $this->belongsTo(User::class);
    }

    public function importexports() {
    	return $this->hasMany(ImportExport::class);
    }
}
