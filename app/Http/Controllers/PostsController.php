<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\Post;
//use Illuminate\Http\Request;
//
//use Illuminate\Support\Facades\Storage;
//
//class PostsController extends Controller
//{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
//
//    public function index()
//    {
//        $users = auth()->user()->following()->pluck('profiles.user_id');
//
//        $posts = Post::whereIn('user_id', $users)
//            ->with('user')
//            ->latest()
//            ->paginate(6);
//// // Square number for grid
//
//       return view('posts.index', compact('posts',));
//    }
//
//    public function create()
//    {
//        return view('posts.create');
//    }
//
//    public function store()
//    {
//        $data = request()->validate([
//            'another' => '', // Optional field from your version
//            'caption' => 'required',
//            'image' => 'required|image',
//        ]);
//
//        $imagePath = request('image')->store('uploads', 'public');
//
//        auth()->user()->posts()->create([
//            'caption' => $data['caption'],
//            'image' => $imagePath,
//        ]);
//
//        return redirect('/profile/' . auth()->user()->id);
//    }
//
//    public function show(Post $post)
//    {
//        return view('posts.show', compact('post'));
//    }
//    public function destroy(Post $post)
//    {
//        $this->authorize('delete', $post);
//
//        // Delete the image file from storage
//        Storage::delete('public/' . $post->image);
//
//        // Soft delete the post
//        $post->delete();
//
//        return redirect('/profile/' . auth()->user()->id)
//            ->with('success', 'Post deleted successfully');
//    }
//
//
//    public function save(Post $post)
//    {
//        $saved = auth()->user()->savedPosts()->toggle($post->id);
//
//        return response()->json([
//            'is_saved' => !empty($saved['attached'])
//        ]);
//    }
//
//}


namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Str;

class PostsController extends Controller
{protected $fillable = ['user_id', 'caption', 'image'];
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');
        $allTags = Tag::select('name')->distinct()->get();

        $posts = Post::whereIn('user_id', $users)
            ->with('user')
            ->latest()
            ->paginate(9);

        return view('posts.index', compact('posts', 'allTags'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required|string',
            'image' => 'required|image',
            'tags' => 'nullable|string|max:255',
            'another' => '', // Optional field from first controller
        ]);
        // Debug: Check if the image is uploaded
        if (!$request->hasFile('image')) {
            return back()->with('error', 'Image upload failed!');
        }
        $imagePath = $request->file('image')->store('uploads', 'public');


        // Debug: Check if storage worked
        if (!$imagePath) {
            return back()->with('error', 'Failed to store image!');
        }

        // Initialize ImageManager
        $manager = new ImageManager(new GdDriver());

        // Store the uploaded image
        $fullPath = storage_path('app/public/' . $imagePath);

        // Resize and crop image
        $image = $manager->read($fullPath)
            ->cover(350, 350)
            ->save($fullPath, quality: 85);

        // Create the post
        $post = auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        // Process tags while preserving #
        if ($request->filled('tags')) {
            // Match all hashtags including adjacent ones like #cool#nature
            preg_match_all('/#\w+/', $request->tags, $matches);

            foreach ($matches[0] as $fullTag) { // Includes #
                $tagName = $fullTag; // Keep the #
                $tag = Tag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug(str_replace('#', '', $tagName))]
                );
                $post->tags()->attach($tag);
            }
        }

        return redirect('/profile/' . auth()->user()->id)
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        // Delete the image file from storage
        Storage::delete('public/' . $post->image);

        // Detach all tags
        $post->tags()->detach();

        // Soft delete the post
        $post->delete();

        return redirect('/profile/' . auth()->user()->id)
            ->with('success', 'Post deleted successfully');
    }

    public function save(Post $post)
    {
        $saved = auth()->user()->savedPosts()->toggle($post->id);

        return response()->json([
            'is_saved' => !empty($saved['attached'])
        ]);
    }
}
