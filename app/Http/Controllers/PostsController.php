<?php

namespace App\Http\Controllers;

use App\Handlers\MarkdownHandler;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Session;
use App\Models\User;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(User $user)
	{

        $active_users = $user->addActiveUser();
		$posts = Post::with('user','category')->withOrder(request('order',''))->paginate();
		return view('posts.index', compact('posts','active_users'));
	}

    public function show(Post $post)
    {
        $convert = new MarkdownHandler();
        $post->body = $convert->convertMarkdownToHtml($post->body);

        return view('posts.show', compact('post'));
    }

	public function create(Post $post)
	{
	    $categories = Category::all();
		return view('posts.create_and_edit', compact('post','categories'));
	}

	public function store(PostRequest $request,Post $post)
	{


		$post->fill($request->all());
		$post->user_id = Auth::id();
		$post->save();

		return redirect()->route('posts.show', $post->id)->with('message', 'Created successfully.');
	}

	public function edit(Post $post)
	{
        $this->authorize('update', $post);
        $categories = Category::all();
        return view('posts.create_and_edit', compact('post','categories'));
	}

	public function update(PostRequest $request, Post $post)
	{
		$this->authorize('update', $post);
		$post->update($request->all());

		return redirect()->route('posts.show', $post->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Post $post)
	{
		$this->authorize('destroy', $post);
		$post->delete();
        session()->flash('success','删除成功');
		return redirect()->route('users.show',Auth::id())->with('message', 'Deleted successfully.');
	}
}
