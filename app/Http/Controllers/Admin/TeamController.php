<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teams\StoreTeam;
use App\Http\Requests\Teams\UpdateTeam;
use App\Models\Teams\Teams;
use App\Models\Teams\TeamsImage;
use Illuminate\Http\Request;
use DB;
use File;
use Carbon\Carbon;

class TeamController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $req = $request->all();
            $sorters = isset($req['sorters']) ? $req['sorters'] : false;
            $filters = isset($req['filters']) ? $req['filters'] : false;

            $categories = Teams::when($sorters, function ($query) use ($sorters) {
                return $sorters[0]['dir'] == 'asc' ? $query->orderBy($sorters[0]['field']) : $query->orderByDesc($sorters[0]['field']);
            })->when($filters, function ($query) use ($filters) {
                switch ($filters[0]['type']){
                    case 'like' :
                        return $query->where($filters[0]['field'],$filters[0]['type'],'%'.$filters[0]['value'].'%');
                    case '=' :
                        return $query->where($filters[0]['field'],$filters[0]['value']);
                    case '!=' :
                        return $query->where($filters[0]['field'],$filters[0]['type'],$filters[0]['value']);
                }
                return $query->where($filters[0]['field'],$filters[0]['type'],'%'.$filters[0]['value'].'%');
            })->paginate((int)(!isset($req['size']) ? 10 : $req['size']));

            return response()->json($categories->toArray());
        }

        return view('admin.teams.index', [
            'layout' => 'side-menu'
        ]);
    }

    /**
     * Create Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        return view('admin.teams.create');
    }

    /**
     * Store The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTeam $request){
        $modifiedFileName = null;
        try {
            DB::beginTransaction();
            $team = new Teams();
            $team->name = $request->nama;
            $team->role = $request->role;
            $team->instagram = $request->instagram;
            $team->facebook = $request->facebook;
            $team->twitter = $request->twitter;
            $team->whatsapp = $request->whatsapp;
            $team->status = isset($request->aktif) ? true : false ;
            $team->save();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $modifiedFileName = $team->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                $teamImage = new TeamsImage();
                $teamImage->teams_id = $team->id;
                $teamImage->original_filename = $originalFileName;
                $teamImage->modified_filename = $modifiedFileName;
                $teamImage->extension = $extension;
                $teamImage->size = $size;
                $teamImage->save();

                $request->file('image')->move(public_path('storage/teams/'), $modifiedFileName);
            }
            DB::commit();
        }catch (\Exception $e){
            if(File::exists(public_path('storage/teams/'.$modifiedFileName))) File::delete(public_path('storage/category/'.$modifiedFileName));
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.teams')
        ]);
    }

    /**
     * Edit Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Request $request){
        $team = Teams::findOrFail($request->id);

        return view('admin.teams.edit',[
            'team' => $team
        ]);
    }

    /**
     * Update The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTeam $request){
        try {
            $team = Teams::findOrFail($request->id);
            $team->name = $request->nama;
            $team->role = $request->role;
            $team->instagram = $request->instagram;
            $team->facebook = $request->facebook;
            $team->twitter = $request->twitter;
            $team->whatsapp = $request->whatsapp;
            $team->status = isset($request->aktif) ? true : false ;
            $team->save();


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $modifiedFileName = $team->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                if ($team->images) {
                    if(File::exists(public_path('storage/teams/'.$team->images->modified_filename))) File::delete(public_path('storage/teams/'.$team->images->modified_filename));
                    $teamImage = TeamsImage::find($team->images->id);
                    $teamImage->teams_id = $team->id;
                    $teamImage->original_filename = $originalFileName;
                    $teamImage->modified_filename = $modifiedFileName;
                    $teamImage->extension = $extension;
                    $teamImage->size = $size;
                    $teamImage->save();
                }else{
                    $teamImage = new TeamsImage();
                    $teamImage->teams_id = $team->id;
                    $teamImage->original_filename = $originalFileName;
                    $teamImage->modified_filename = $modifiedFileName;
                    $teamImage->extension = $extension;
                    $teamImage->size = $size;
                    $teamImage->save();
                }

                $request->file('image')->move(public_path('storage/teams/'), $modifiedFileName);

            }
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.teams')
        ]);
    }

    /**
     * Delete Method using Soft Delete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){
        if ($request->ajax()){
            try {
                DB::beginTransaction();
                $team = Teams::findOrFail($request->id);
                if ($team->images) {
                    if(File::exists(public_path('storage/teams/'.$team->images->modified_filename))) File::delete(public_path('storage/teams/'.$team->images->modified_filename));
                    $teamImage = TeamsImage::find($team->images->id);
                    $teamImage->delete();
                }
                $team->delete();
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();

                return response()->json([
                    'message' => 'error',
                    'description' => $e->getMessage()
                ],500);
            }

            return response()->json(['message' => 'success']);
        }

        abort(403);
    }


}
