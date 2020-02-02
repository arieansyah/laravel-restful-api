<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use Auth;
use Validator;
use App\Http\Resources\Post as PostResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Events\PostEvent;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request, Post $post)
    {
        $this->authorize('store', $post);

        $img = $request->file('image');
        $img_path = $img->store('post', 'public');

        $news = Post::create($request->all());
        $news->image = $img_path;
        $news->save();
        return new PostResource($news);

        event(new PostEvent($store));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post, $id)
    {
        $this->authorize('update', $post);

        $img = $request->file('image');
        $requestData = $request->all();
        $requestData['image'] = $img->store('post', 'public');
        $post->find($id)->update($requestData);

        event(new PostEvent($post));
        return new PostResource($post->find($id));

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, $id)
    {
        $this->authorize('delete', $post);

        $data = $post->find($id);
        if ($data) {
            $data->delete();
            $message = "Delete Post Success";
            event(new PostEvent($data));
        } else {
            $message = "Delete Post Failed";
        }
        return response()->json(['message' => $message]);
    }
}
