<?php

namespace App\Http\Controllers;


use App\Models\Article\Article;
use App\Models\Contact;
use App\Models\Question\Category;
use App\Models\Teams\Teams;
use Illuminate\Support\Facades\Request;

class PageController extends Controller
{
    /**
     * Show specified view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::where('status',true)->get();
        $teams = Teams::where('status',true)->get();
        $contact = Contact::first();
        $articles = Article::where('status',true)->get();
        return view('index', [
            'categories' => $category,
            'teams' => $teams,
            'contact' => $contact,
            'articles' => $articles
        ]);
    }

    /**
     * Detail View.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function artikel(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        return view('artikel.detail', [
            'article' => $article
        ]);
    }

}
