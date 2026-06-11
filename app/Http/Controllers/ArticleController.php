<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    // ─── PUBLIC ──────────────────────────────────────────────────────────────

    public function publicIndex()
    {
        $articles = Article::latest()->paginate(12);
        return view('blog.index', compact('articles'));
    }

    public function publicShow(string $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Find previous and next articles by id
        $previous = Article::where('id', '<', $article->id)->latest('id')->first();
        $next     = Article::where('id', '>', $article->id)->oldest('id')->first();

        return view('blog.show', compact('article', 'previous', 'next'));
    }

    // ─── ADMIN ───────────────────────────────────────────────────────────────

    public function uploadInlineImage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,txt|max:5120',
        ]);

        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $path = $this->imageService->optimizeBlogInlineImage($file);
                } else {
                    $filename = \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('docs/blog_inline', $filename, 'public');
                }
                
                return response()->json([
                    'url'  => asset('storage/' . $path),
                    'href' => asset('storage/' . $path)
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

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
            'published_date' => 'nullable|date',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            try {
                // Optimasi: resize maks 1000px lebar, konversi webp 75% quality
                $imagePath = $this->imageService->optimizeBlogImage($request->file('image'));
            } catch (\Exception $e) {
                return back()->withInput()
                             ->with('error', 'Gagal memproses gambar. Pastikan file yang diunggah adalah gambar yang valid. (' . $e->getMessage() . ')');
            }
        }

        $createdAt = $request->published_date ? \Carbon\Carbon::parse($request->published_date) : now();

        $article = new Article([
            'title'    => $request->title,
            'slug'     => Str::slug($request->title) . '-' . Str::random(5),
            'content'  => $request->content,
            'image'    => $imagePath,
            'id_admin' => Auth::id(),
        ]);
        
        $article->timestamps = false;
        $article->created_at = $createdAt;
        $article->updated_at = $createdAt;
        $article->save();

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function edit(Article $article)
    {
        return view('admin.blog.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'published_date' => 'nullable|date',
        ]);

        $data = [
            'title'   => $request->title,
            'slug'    => Str::slug($request->title) . '-' . Str::random(5),
            'content' => $request->content,
        ];

        $createdAt = $request->filled('published_date') 
            ? \Carbon\Carbon::parse($request->published_date) 
            : $article->created_at;

        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama, lalu simpan yang baru (optimized)
                $this->imageService->deleteOldImage($article->image);
                $data['image'] = $this->imageService->optimizeBlogImage($request->file('image'));
            } catch (\Exception $e) {
                return back()->withInput()
                             ->with('error', 'Gagal memproses gambar. Pastikan file yang diunggah adalah gambar yang valid. (' . $e->getMessage() . ')');
            }
        }

        $article->fill($data);
        $article->timestamps = false;
        $article->created_at = $createdAt;
        $article->updated_at = $createdAt;
        $article->save();

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $this->imageService->deleteOldImage($article->image);
        $article->delete();

        return redirect()->route('admin.blog.index')
                         ->with('success', 'Artikel berhasil dihapus.');
    }
}
