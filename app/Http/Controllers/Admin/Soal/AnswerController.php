<?php

namespace App\Http\Controllers\Admin\Soal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soal\Answer\StoreAnswer;
use App\Http\Requests\Soal\Answer\UpdateAnswer;
use App\Models\Question\QuestionAnswer;
use Illuminate\Http\Request;

class AnswerController extends Controller
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

            $question = QuestionAnswer::where('question_id',$request->question_id)
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

        return view('admin.soal.jawaban.index', [
            'layout' => 'side-menu',
            'category_id' => $request->question_category_id,
            'soal_id' => $request->question_id
        ]);
    }

    /**
     * Create Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        return view('admin.soal.jawaban.create',[
            'category_id' => $request->question_category_id,
            'soal_id' => $request->question_id
        ]);
    }

    /**
     * Store The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswer $request){

        $jawaban = new QuestionAnswer();
        $jawaban->answer = $request->jawaban;
        $jawaban->question_id = $request->soal_id;
        $jawaban->point = $request->poin;
        $jawaban->save();

        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.question.answer', [$request->question_category_id,$jawaban->question_id])
        ]);
    }

    /**
     * Edit Form View.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $jawaban = QuestionAnswer::findOrFail($request->id);

        return view('admin.soal.jawaban.edit',[
            'jawaban' => $jawaban,
            'category_id' => $request->question_category_id,
            'soal_id' => $request->question_id
        ]);
    }

    /**
     * Update The data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswer $request){
        $jawaban = QuestionAnswer::findOrFail($request->id);
        $jawaban->question_id = $request->soal_id;
        $jawaban->answer = $request->jawaban;
        $jawaban->point = $request->poin;
        $jawaban->save();

        return response()->json([
            'message'=>'success',
            'redirect' => route('admin.question.answer',[$request->question_category_id,$jawaban->question_id])
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
            $jawaban = QuestionAnswer::findOrFail($request->id);
            $jawaban->delete();

            return response()->json(['message' => 'success']);
        }

        abort(403);
    }
}
