<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Jobs\Job;

class PostController extends Controller
{
    public function show(Request $request){
        return Post::where(['website_id' => $request->webID, 'status' => 1])->get();
    }

    public function store(Request $request){
        $this->validate($request, [
            'websiteID' => 'required',
            'title' => 'required|max:255|string',
            'description' => 'required',
        ]);

        $modal = new Post();
        $modal->website_id = $request->websiteID;
        $modal->title = $request->title;
        $modal->description = $request->description;
        $modal->save();

        if ($modal->save()) {
            /* QUEUE Job */
            $job = (new Job($request->websiteID, $modal->id));
            $this->dispatch($job);
            return response()->json(['success' => true, 'message' => 'Created successfully'], 200);

        } else {
            return response()->json (['success' => false, 'error' => 'Ubable to create'],422);
        }
    }
}
