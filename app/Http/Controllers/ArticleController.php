<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // ─── PUBLIC ──────────────────────────────────────────────────────────────

    public function publicIndex()
    {
        $articles = Article::latest()->paginate(12);
        return view('blog.index', compact('articles'));
    }

    public function publicShow(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('article'));
    }

    // ─── ADMIN ───────────────────────────────────────────────────────────────

    public function adminIndex()
    {
        $articles = Article::latest()->paginate(15);
        return view('admin.blog.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        Article::create([
            'title'    => $request->title,
            'slug'     => Str::slug($request->title) . '-' . Str::random(5),
            'content'  => $request->content,
            'image'    => $imagePath,
            'id_admin' => Auth::id(),
        ]);

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Artikel berhasil dihapus.');
    }
}
