<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question\Category;
use App\Models\Question\Question;
use App\Models\Question\QuestionAnswer;
use App\Models\Teams\Teams;
use App\Models\Test\UserTest;
use App\Models\User\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show specified view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [
            'user' => [
                'member'    => User::where('admin', false)->count(),
                'admin'     => User::where('admin', true)->count(),
                'url'       => null
            ],
            'teams' => Teams::where('status',true)->get(),
            'soal' => [
                'url' => route('admin.question.category'),
                'total' => [
                    'category' => Category::count(),
                    'question'  => Question::count(),
                    'answer'    =>  QuestionAnswer::count()
                ]
            ],
            'userTest' => [
                'user' => UserTest::all()
            ]
        ];

        return view('admin.index', [
            'data' => $data
            // Specify the base layout.
            // Eg: 'side-menu', 'simple-menu', 'top-menu', 'login'
            // The default value is 'side-menu'

            // 'layout' => 'side-menu'
        ]);
    }
}
