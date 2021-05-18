<?php

namespace App\Http\Controllers\Admin\Soal;

use App\Http\Controllers\Controller;
use App\Models\Question\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index(Request $request, $id)
    {
        $result = Result::where('question_category_id', $id)->first();
        if (!$result) {
            $result = new Result();
            $result->question_category_id = $id;
            $result->save();
        }

        return view('admin.soal.result', [
            'result' => $result
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $result = Result::findOrFail($id);
            $result->cat_a = $request->cat_a;
            $result->cat_b = $request->cat_b;
            $result->cat_c = $request->cat_c;
            $result->cat_d = $request->cat_d;
            $result->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'success',
                'description' => $e->getMessage()
            ],500);
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('admin.question.category')
        ]);
    }
}
