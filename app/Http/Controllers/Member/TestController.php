<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Question\Category;
use App\Models\Test\UserAnswer;
use App\Models\Test\UserAnswerHistory;
use App\Models\Test\UserTest;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $request){
        $categories  = Category::where('status',true)->get();

        return view('member.pages.test.index',[
            'categories' => $categories
        ]);
    }

    public function history(Request $request){
        $categories  = Category::whereHas('hasUser')->get();

        return view('member.pages.test.history',[
            'categories' => $categories
        ]);
    }

    public function historyTest(Request $request,$id){
        $user  = UserTest::where('user_id',Auth::id())->where('question_category_id',$id)->first();

        if(!$user) abort(404);
        return view('member.pages.test.historytest',[
            'user' => $user
        ]);
    }

    public function start(Request $request,$id){
        $category  = Category::where('status',true)->where('id',$id)->first();

        if($category){
            $test = UserTest::where('user_id',Auth::id())->where('question_category_id',$id)->first();
            if($test){
                if($test->state == 'finish'){
                    abort(404);
                }
                $test->state = 'continue';
                $test->save();
            }else{
                $test = new UserTest();
                $test->user_id = Auth::id();
                $test->question_category_id = $category->id;
                $test->category_name = $category->category;
                $test->state = 'continue';
                $test->point = 0;
                $test->start = Carbon::now();
                $test->save();
            }

            return view('member.pages.test.test',[
                'category' => $category
            ]);
        }
        abort(404);
    }


    public function save(Request $request,$id){
        $category  = Category::where('status',true)->where('id',$id)->first();

        $req = $request->all();

        if($category){
            try{
                DB::beginTransaction();
                $test = UserTest::where('user_id',Auth::id())->where('question_category_id',$id)->first();
                $point = 0;
                if($test){
                    $test->state = 'finish';
                    $test->end = Carbon::now();
                }else{
                    abort(404);
                }

                foreach($req['jawaban'] as $key => $jawaban){
                    $soal = $category->soal->where('id',$req['soal'][$key])->first();
                    $jawabanData = $soal->answers->where('id',$jawaban)->first();
                    $user_jawaban = new UserAnswer();
                    $user_jawaban->user_test_id = $test->id;
                    $user_jawaban->question_id = $soal->id;
                    $user_jawaban->question = $soal->question;
                    $user_jawaban->question_answer_id = $jawabanData->id;
                    $user_jawaban->point = $jawabanData->point;
                    $point += $jawabanData->point;
                    $user_jawaban->save();

                    foreach($soal->answers as $value){
                        $user_history = new UserAnswerHistory();
                        $user_history->user_answer_id = $user_jawaban->id;
                        $user_history->question_answer_id = $value->id;
                        $user_history->answer = $value->answer;
                        $user_history->point = $value->point;
                        $user_history->save();
                    }
                }
                $test->point = $point;
                $test->save();
                DB::commit();
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json([
                    'message' => 'error',
                    'description' => $e->getMessage()
                ],500);
            }

            return response()->json([
                'message' => 'success',
                'redirect'   => route('member.history')
            ]);
        }
        abort(404);
    }
}
