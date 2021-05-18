<?php

namespace App\Http\Controllers\Admin\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soal\Category\StoreCategory;
use App\Http\Requests\Soal\Category\UpdateCategory;
use App\Models\Question\Category;
use App\Models\Question\CategoryImage;
use App\Models\Question\Question;
use App\Models\Question\QuestionAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use File;

class CategoryController extends Controller
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

            $categories = Category::when($sorters, function ($query) use ($sorters) {
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

        return view('admin.soal.kategori.index', [
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
        return view('admin.soal.kategori.create');
    }

    /**
     * Store The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCategory $request){
        try {
            DB::beginTransaction();
                $category = new Category();
                $category->category = $request->kategori;
                $category->description = $request->deskripsi;
                $category->icon = $request->icon;
                $category->status = isset($request->aktif) ? true : false ;
                $category->save();

            if ($request->hasFile('background')) {
                $image = $request->file('background');
                $modifiedFileName = $category->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                $categoryImage = new CategoryImage();
                $categoryImage->question_category_id = $category->id;
                $categoryImage->original_filename = $originalFileName;
                $categoryImage->modified_filename = $modifiedFileName;
                $categoryImage->extension = $extension;
                $categoryImage->size = $size;
                $categoryImage->save();

                $request->file('background')->move(public_path('storage/category/'), $modifiedFileName);
            }
            DB::commit();
        }catch (\Exception $e){
           if(File::exists(public_path('storage/category/'.$modifiedFileName))) File::delete(public_path('storage/category/'.$modifiedFileName));
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.question.category')
        ]);
    }

    /**
     * Edit Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Request $request){
        $category = Category::findOrFail($request->id);

        return view('admin.soal.kategori.edit',[
            'category' => $category
        ]);
    }

    /**
     * Update The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategory $request){
        try {
            $category = Category::findOrFail($request->id);
            $category->category = $request->kategori;
            $category->description = $request->deskripsi;
            $category->icon = $request->icon;
            $category->status = isset($request->aktif) ? true : false ;
            $category->save();


            if ($request->hasFile('background')) {
                $image = $request->file('background');
                $modifiedFileName = $category->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                if ($category->images) {
                    if(File::exists(public_path('storage/category/'.$category->images->modified_filename))) File::delete(public_path('storage/category/'.$category->images->modified_filename));
                    $categoryImage = CategoryImage::find($category->images->id);
                    $categoryImage->question_category_id = $category->id;
                    $categoryImage->original_filename = $originalFileName;
                    $categoryImage->modified_filename = $modifiedFileName;
                    $categoryImage->extension = $extension;
                    $categoryImage->size = $size;
                    $categoryImage->save();
                }else{
                    $categoryImage = new CategoryImage();
                    $categoryImage->question_category_id = $category->id;
                    $categoryImage->original_filename = $originalFileName;
                    $categoryImage->modified_filename = $modifiedFileName;
                    $categoryImage->extension = $extension;
                    $categoryImage->size = $size;
                    $categoryImage->save();
                }

                $request->file('background')->move(public_path('storage/category/'), $modifiedFileName); 
                
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
            'redirect' => route('admin.question.category')
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
                $category = Category::findOrFail($request->id);
                if ($category->images) {
                    if(File::exists(public_path('storage/category/'.$category->images->modified_filename))) File::delete(public_path('storage/category/'.$category->images->modified_filename));
                    $categoryImage = CategoryImage::find($category->images->id);
                    $categoryImage->delete();
                }
                $soal = Question::select('id')->where('question_category_id',$category->id)->get();
                foreach ($soal as $value){
                    QuestionAnswer::where('question_id',$value->id)->delete();
                    $value->delete();
                }
                $category->delete();
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
