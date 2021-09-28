<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show(Request $request){
        return User::where(['website_id' => $request->webID])->get();
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|max:255|string',
            'email' => 'required',
        ]);

        $modal = new User();
        $modal->name = $request->name;
        $modal->email = $request->email;
        $modal->save();

        if ($modal->save()){
            return response()->json(['success' => true, 'message' => 'Created successfully'], 200);
        } else {
            return response()->json(['success' => false, 'error' => 'Ubable to create'], 422);
        }
    }
}
