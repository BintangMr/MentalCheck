<?php

namespace App\Http\Controllers\Admin\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soal\StoreQuestion;
use App\Http\Requests\Soal\UpdateQuestion;
use App\Models\Question\Category;
use App\Models\Question\Question;
use App\Models\Question\QuestionAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $req = $request->all();
            $sorters = isset($req['sorters']) ? $req['sorters'] : false;
            $filters = isset($req['filters']) ? $req['filters'] : false;

            $question = Question::where('question_category_id',$request->question_category_id)
                ->when($sorters, function ($query) use ($sorters) {
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

            return response()->json($question->toArray());
        }

        $category = Category::findOrFail($request->question_category_id);
        return view('admin.soal.index', [
            'layout' => 'side-menu',
            'category_id' => $category->id,
            'category_name' => $category->category
        ]);
    }

    /**
     * Create Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        return view('admin.soal.create',[
            'category_id' => $request->question_category_id
        ]);
    }

    /**
     * Store The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestion $request){

        try {
            DB::beginTransaction();
            $soal = new Question();
            $soal->question = $request->soal;
            $soal->question_category_id = $request->kategori_id;
            $soal->status = isset($request->aktif) ? true : false ;
            $soal->save();

            $req = $request->all();
            if(isset($req['text_jawaban'][0])){
                foreach ($req['text_jawaban'] as $key => $value){
                    $jawaban = new QuestionAnswer();
                    $jawaban->answer = $value;
                    $jawaban->question_id = $soal->id;
                    $jawaban->point = $req['point_jawaban'][$key];
                    $jawaban->save();
                }
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message'=>'error',
                'description' => $e->getMessage()
            ],500);
        }


        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.question', $soal->question_category_id)
        ]);
    }

    /**
     * Edit Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $soal = Question::findOrFail($request->id);

        return view('admin.soal.edit',[
            'soal' => $soal,
            'category_id' => $request->question_category_id
        ]);
    }

    /**
     * Update The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestion $request){
        try {
            DB::beginTransaction();
            $soal = Question::findOrFail($request->id);
            $soal->question = $request->soal;
            $soal->question_category_id = $request->kategori_id;
            $soal->status = isset($request->aktif) ? true : false ;
            $soal->save();

            $req = $request->all();
            if(isset($req['text_jawaban'][0])){
                foreach ($req['text_jawaban'] as $key => $value){
                    if($req['id_jawaban'][$key]){
                        $jawaban = QuestionAnswer::findOrFail($req['id_jawaban'][$key]);
                        $jawaban->answer = $value;
                        $jawaban->question_id = $soal->id;
                        $jawaban->point = $req['point_jawaban'][$key];
                        $jawaban->save();
                    }else {
                        $jawaban = new QuestionAnswer();
                        $jawaban->answer = $value;
                        $jawaban->question_id = $soal->id;
                        $jawaban->point = $req['point_jawaban'][$key];
                        $jawaban->save();
                    }
                }
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'message'=>'error',
                'description' => $e->getMessage()
            ],500);
        }

        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.question',$soal->question_category_id)
        ]);
    }

    /**
     * Delete Method using Soft Delete.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request){
        if ($request->ajax()){
            $soal = Question::findOrFail($request->id);
            $soal->delete();
            QuestionAnswer::where('question_id',$soal->id)->delete();

            return response()->json(['message' => 'success']);
        }

        abort(403);
    }
}
