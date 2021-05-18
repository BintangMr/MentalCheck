<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\StoreArticle;
use App\Http\Requests\Article\UpdateArticle;
use App\Models\Article\Article;
use App\Models\Article\ArticleImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    /**
     * Show specified view.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $article = Article::paginate(10);

        return view('admin.article.index', [
            'layout' => 'side-menu',
            'article' => $article
        ]);
    }

    /**
     * Create Form View.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.article.create');
    }

    /**
     * Store The data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreArticle $request)
    {
        $modifiedFileName = null;
        try {
            DB::beginTransaction();
            $article = new Article();
            $article->title = $request->judul;
            $article->description = $request->deskripsi;
            $article->caption = $request->caption;
            $article->status = isset($request->aktif) ? true : false;
            $article->save();

            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $modifiedFileName = $article->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                $articleImage = new ArticleImage();
                $articleImage->article_id = $article->id;
                $articleImage->original_filename = $originalFileName;
                $articleImage->modified_filename = $modifiedFileName;
                $articleImage->extension = $extension;
                $articleImage->size = $size;
                $articleImage->save();

                $request->file('gambar')->move(public_path('storage/article/'), $modifiedFileName);
            }
            DB::commit();
        } catch (\Exception $e) {
            if (File::exists(public_path('storage/article/' . $modifiedFileName))) File::delete(public_path('storage/article/' . $modifiedFileName));
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'message' => 'success',
            'redirect' => route('admin.article')
        ]);
    }

    /**
     * Detail View.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $article = Article::findOrFail($request->id);

        return view('admin.article.detail', [
            'article' => $article
        ]);
    }

    /**
     * Edit Form View.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $article = Article::findOrFail($request->id);

        return view('admin.article.edit', [
            'article' => $article
        ]);
    }

    /**
     * Update The data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticle $request)
    {
        try {
            $article = Article::findOrFail($request->id);
            $article->title = $request->judul;
            $article->description = $request->deskripsi;
            $article->caption = $request->caption;
            $article->status = isset($request->aktif) ? true : false;
            $article->save();


            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $modifiedFileName = $article->id . '-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
                $originalFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $size = 0;

                if ($article->images) {
                    if (File::exists(public_path('storage/article/' . $article->images->modified_filename))) File::delete(public_path('storage/article/' . $article->images->modified_filename));
                    $articleImage = ArticleImage::find($article->images->id);
                    $articleImage->article_id = $article->id;
                    $articleImage->original_filename = $originalFileName;
                    $articleImage->modified_filename = $modifiedFileName;
                    $articleImage->extension = $extension;
                    $articleImage->size = $size;
                    $articleImage->save();
                } else {
                    $articleImage = new ArticleImage();
                    $articleImage->article_id = $article->id;
                    $articleImage->original_filename = $originalFileName;
                    $articleImage->modified_filename = $modifiedFileName;
                    $articleImage->extension = $extension;
                    $articleImage->size = $size;
                    $articleImage->save();
                }

                $request->file('gambar')->move(public_path('storage/article/'), $modifiedFileName);

            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error',
                'detail' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'success',
            'redirect' => route('admin.article')
        ]);
    }

    /**
     * Delete Method using Soft Delete.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $article = Article::findOrFail($id);
            if ($article->images) {
                if (File::exists(public_path('storage/article/' . $article->images->modified_filename))) File::delete(public_path('storage/article/' . $article->images->modified_filename));
                $articleImage = ArticleImage::find($article->images->id);
                $articleImage->delete();
            }
            $article->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'error',
                'description' => $e->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'success']);
    }
}
