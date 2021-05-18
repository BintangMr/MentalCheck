<?php

namespace App\Http\Controllers;

use App\Models\User\UserActivities;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileView(Request $request)
    {
        $logs = UserActivities::where('user_id',\Auth::id())->get();
        return view('beranda/profile',[
            'logs' => $logs,
            'user' => \Auth::user()->name
        ]);
    }

    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileEditView(Request $request)
    {
        $logs = UserActivities::where('user_id',\Auth::id())->get();
        return view('beranda.editProfile',[
            'logs' => $logs,
        ]);
    }
}
