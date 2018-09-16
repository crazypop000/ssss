<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportExport;
use App\User;

class ImportExportController extends Controller
{
    public function index() {
    	$user = new User();
    	$user = $user->getCurrentUser();
    	if($user->hasRole(['baker'])) {
    		$history = ImportExport::where('type', '=', 'import')->get()->load('user');
    	}
    	else if($user->hasRole(['employee'])) {
    		$history = ImportExport::where('type', '=', 'export')->get()->load('user');
    	}
    	else {
    		$history = ImportExport::get()->load('user');
    	}
    	return $history;
    }
}
