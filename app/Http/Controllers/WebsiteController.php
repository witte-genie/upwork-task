<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebsiteController extends Controller
{
    public function index(){
        return Website::all();
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required|max:255|string',
            'url' => 'required',
        ]);

        $modal = new Website();
        $modal->title = $request->title;
        $modal->url = $request->url;
        $modal->save();

        if ($modal->save()) {
            return response()->json(['success' => true, 'message' => 'Created successfully'], 200);
        } else {
            return response()->json (['success' => false, 'error' => 'Ubable to create'],422);
        }
    }
}
