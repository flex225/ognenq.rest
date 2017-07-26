<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Image;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //TODO create validation
      $post = new Post();
      $post->user_id = 1;
      $post->type_id = 1;
      $post->save();
      $post->tags()->sync([1,2,3]);//TODO remove hardcode
      // print_r(Image::createImages(1, ["art", "din", "art2"]));
      $images = Image::createImages($post->id, array("art4", "din4", "art6"));
      // dd($images);
      $post->images()->saveMany($images);
      return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id)
          ->with('tags')
          ->with('type')
          ->with('user')
          ->get();
        // dd($post);
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $post = Post::find($id);
      $post->type_id = 4;
      $post->save();
      $post->tags()->sync($request->tags);//TODO remove hardcode

      return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        $post->delete();

        //TODO return
    }

    /**
    * Filter posts by their tags and postType
    */
    public function filterPosts(Request $request) {
      $postType = $request->type;
      $tags = $request->tags;
      $filteredPostsQueryBuilder = Post::query();

      if ($postType) {
        $filteredPostsQueryBuilder->where('type_id', $postType);
      }
      if ($tags) {
        $filteredPostsQueryBuilder->whereHas('tags', function($query) use ($tags) {
          $query->whereIn('tag_id', $tags);
        });
      }
      if (count($filteredPostsQueryBuilder->get()) == 0) {
        //return there is no items for your request or return empty array
      }
      $filteredPostsQueryBuilder->orderBy('updated_at', 'desc');

      return $filteredPostsQueryBuilder->get();
    }
}
