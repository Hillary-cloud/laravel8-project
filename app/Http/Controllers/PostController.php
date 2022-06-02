<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware(['auth'])->only(['store','destroy']);
    }
    public function index(){

        $posts = Post::orderBy('created_at', 'desc')->with(['user','likes'])->paginate(10);//or Post::latest()->paginate(3). to get all the posts

        return view('posts.index', [
            'posts'=>$posts
        ]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'body'=>'required',

        ]);

        $request->user()->posts()->create($request->only('body'));
        return back();
    }
    public function destroy(Post $post){
        $post->delete();
        return back();
    }
}
