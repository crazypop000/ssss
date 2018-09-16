<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Material;
use App\ImportExport;
use App\Events\MessagePosted;

class MaterialController extends Controller
{
    public function index(Request $request) {
        broadcast(new MessagePosted('Hello world'));
    	return Material::get()->load('user');
    }

    public function create(Request $request) {
    	$data = $request->input('material');
    	$material = new Material();
    	$material->name = $data['name'];
    	$material->quantity = $data['quantity'];
    	$material->user_id = $data['user_id'];
    	$material->save();

        $user = new User();

        ImportExport::create([
            'type' => 'import',
            'action' => 'create',
            'description' => 'Thêm mới <b>'.$material->quantity.'</b> đơn vị <b>'.$material->name.'</b>',
            'material_id' => $material->id,
            'user_id' => $user->getCurrentUser()->id
        ]);
    	
    	return response('success');
    }

    public function edit(Request $request) {
    	$data = $request->input('material');
    	$material = Material::find($data['id']);

        $oldName = $material->name;
        $oldQuantity = $material->quantity;

        $text_name = 'chuyển tên từ <b>'.$oldName.'</b> thành <b>'.$data['name'].'</b>,';
        $text_quantity = 'chuyển số lượng từ <b>'.$oldQuantity.'</b> thành <b>'.$data['quantity'].'</b> đơn vị,';
        $text = '';
        if($oldName !== $data['name']) {
            $text = $text.$text_name;
        }

        if($oldQuantity !== $data['quantity']) {
            $text = $text.$text_quantity;
        }

    	$material->name = $data['name'];
    	$material->quantity = $data['quantity'];
    	$material->save();

        $user = new User();

        ImportExport::create([
            'type' => 'import',
            'action' => 'edit',
            'description' => rtrim($text,','),
            'material_id' => $material->id,
            'user_id' => $user->getCurrentUser()->id
        ]);
    	
    	return response('success');
    }

    public function export(Request $request) {
    	$data = $request->input('material');
    	$quantity = $request->input('quantity');
    	$material = Material::find($data['id']);
        $name = $material->name;
        $id = $material->id;
    	$material->quantity = $data['quantity'] - $quantity;
    	if($material->quantity == 0) {
    		$material->delete();
    	}
    	else {
    		$material->save();
    	}

        $user = new User();

        ImportExport::create([
            'type' => 'export',
            'action' => 'export',
            'description' => 'Xuất <b>'.$quantity.' đơn vị</b> của nguyên liệu <b>'.$name.'</b>',
            'material_id' => $id,
            'user_id' => $user->getCurrentUser()->id
        ]);

    	return response('success');
    }

    public function delete(Request $request) {
    	$data = $request->input('material');
    	$material = Material::find($data['id']);
        $name = $material->name;
        $id = $material->id;
		$material->delete();

        $user = new User();

        ImportExport::create([
            'type' => 'import',
            'action' => 'delete',
            'description' => 'Xoá nguyên liệu <b>'.$name.'</b>',
            'material_id' => $id,
            'user_id' => $user->getCurrentUser()->id
        ]);

    	return response('success');
    }
}
