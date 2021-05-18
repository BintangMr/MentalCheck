<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateIdentitas;
use App\Http\Requests\User\UpdatePassword;
use App\Models\User\User;
use App\Models\User\UserImages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $req = $request->all();
            $sorters = isset($req['sorters']) ? $req['sorters'] : false;
            $filters = isset($req['filters']) ? $req['filters'] : false;

            $users = User::when($sorters, function ($query) use ($sorters) {
                return $sorters[0]['dir'] == 'asc' ? $query->orderBy($sorters[0]['field']) : $query->orderByDesc($sorters[0]['field']);

            })->when($filters, function ($query) use ($filters) {
                if ($filters[0]['type'] == 'role') {
                    if ($filters[0]['value'] == 'admin') {
                        return $query->where('admin', true);
                    } else if ($filters[0]['value'] == 'member') {
                        return $query->where('admin', false);
                    }
                } else {
                    switch ($filters[0]['type']) {
                        case 'like' :
                            return $query->where($filters[0]['field'], $filters[0]['type'], '%' . $filters[0]['value'] . '%');
                        case '=' :
                            return $query->where($filters[0]['field'], $filters[0]['value']);
                        case '!=' :
                            return $query->where($filters[0]['field'], $filters[0]['type'], $filters[0]['value']);
                    }
                }

                return $query->where($filters[0]['field'], $filters[0]['type'], '%' . $filters[0]['value'] . '%');
            })->paginate((int)(!isset($req['size']) ? 10 : $req['size']));

            return response()->json($users->toArray());
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->no_telepon;
            $user->address = $request->alamat;
            $user->admin = $request->role;
            $user->save();

            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $modifiedFileName = $user->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                $userImage = new UserImages();
                $userImage->user_id = $user->id;
                $userImage->original_filename = $originalFileName;
                $userImage->modified_filename = $modifiedFileName;
                $userImage->extension = $extension;
                $userImage->size = $size;
                $userImage->save();

                $request->file('avatar')->move(public_path('storage/avatars/'), $modifiedFileName);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if(File::exists(public_path('storage/avatars/'.$modifiedFileName))) File::delete(public_path('storage/avatars/'.$modifiedFileName));
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('admin.user')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.detail', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateIdentitas(UpdateIdentitas $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->name = $request->nama;
            $user->email = $request->email;
            $user->phone = $request->no_telepon;
            $user->address = $request->alamat;
            $user->admin = $request->role == 'true' ? true : false;
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
            'redirect' => route('admin.user.edit',$user->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePassword $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
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
            'redirect' => route('admin.user.edit',$user->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $user = User::findOrFail($request->id);
            if ($user->ava) {
                if(File::exists(public_path('storage/avatars/'.$user->ava->modified_filename))) File::delete(public_path('storage/avatars/'.$user->ava->modified_filename));
                $userImage = UserImages::find($user->ava->id);
                $userImage->delete();
            }
            $user->delete();

            return response()->json(['message' => 'success']);
        }

        abort(403);
    }
}
