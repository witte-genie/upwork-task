<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class SubscribeController extends Controller
{
    public function index(){
        $users = DB::SELECT("SELECT
            u.name as user_name,
            GROUP_CONCAT(w.title) AS websites
            FROM `subscribe`
            LEFT JOIN users AS u ON u.id=subscribe.user_id
            LEFT JOIN websites AS w ON w.id=subscribe.website_id
            GROUP BY subscribe.user_id"
        );

        return $users;
    }

    public function store(Request $request){
        try {
            $user = User::find($request->user_id);
            if(!$user)
                throw new \Exception('Invalid user id. Please registered this user first');

            $website = Website::find($request->website_id);
            if(!$website)
                throw new \Exception('Invalid website id. Please registered this website first');

            if (DB::table('subscribe')->where(['user_id' => $request->user_id, 'website_id' => $request->website_id])->doesntExist()) {

                $this->validate($request, [
                    'user_id' => 'required',
                    'website_id' => 'required',
                ]);


                $modal = new Subscribe();
                $modal->user_id = $request->user_id;
                $modal->website_id = $request->website_id;
                $modal->save();

                if ($modal->save()) {
                    return response()->json(['success' => true, 'message' => 'Created successfully'], 200);
                } else {
                    return response()->json(['success' => false, 'error' => 'Ubable to create'], 422);
                }
            } else {
                return response()->json(['success' => false, 'error' => 'User already subscribed in this website'], 422);
            }

        } catch (\Exception $e){
            return response()->json (['success' => false, 'error' => 'Ubable to create'],422);
        }
    }
}
