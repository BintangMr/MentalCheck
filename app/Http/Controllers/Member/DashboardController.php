<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Update\Identitas;
use App\Http\Requests\Member\Update\Password;
use App\Models\User\User;
use App\Models\User\UserImages;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;

class DashboardController extends Controller
{
    public function index(){
        return view('member.index');
    }

    public function profile(){
        return view('member.pages.profile.profile');
    }

    public function updateIdentitias(Identitas $request){
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth::id());
            $user->name = $request->nama;
            $user->phone = $request->no_telepon;
            $user->address = $request->alamat;
            $user->save();

            if ($request->removePhoto == 'true') {
               if(File::exists(public_path('storage/avatars/'.$user->ava->modified_filename))) File::delete(public_path('storage/avatars/'.$user->ava->modified_filename));
                $userImage = UserImages::find($user->ava->id);
                if ($userImage) $userImage->delete();

            }

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $modifiedFileName = $user->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                if ($user->ava) {
                    if(File::exists(public_path('storage/avatars/'.$user->ava->modified_filename))) File::delete(public_path('storage/avatars/'.$user->ava->modified_filename));
                    $userImage = UserImages::find($user->ava->id);
                    $userImage->user_id = $user->id;
                    $userImage->original_filename = $originalFileName;
                    $userImage->modified_filename = $modifiedFileName;
                    $userImage->extension = $extension;
                    $userImage->size = $size;
                    $userImage->save();
                }else{
                    $userImage = new UserImages();
                    $userImage->user_id = $user->id;
                    $userImage->original_filename = $originalFileName;
                    $userImage->modified_filename = $modifiedFileName;
                    $userImage->extension = $extension;
                    $userImage->size = $size;
                    $userImage->save();
                }

                $request->file('avatar')->move(public_path('storage/avatars/'), $modifiedFileName);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('member.profile')
        ]);
    }

    public function updatePassword(Password $request){
        try {
            DB::beginTransaction();
            $user = User::findOrFail(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('member.profile')
        ]);
    }
}
