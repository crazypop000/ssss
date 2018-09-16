<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Material;
use App\User;

class ImportExport extends Model
{
    protected $table = 'in_out';

    protected $fillable = ['type', 'action', 'material_id', 'user_id', 'description'];

    public function material()
    {
    	return $this->belongsTo(Material::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
