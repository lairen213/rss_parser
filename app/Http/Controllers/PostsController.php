<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function getAllPosts(Request $request){
        $posts = Post::where('deleted', 0)->get();


        foreach($posts as $post)
            $post['categories'] = $this->stringToArray($post['categories']);

        return response()->json(['status' => 'ok', 'data' => $posts], 200);
    }

    public function getOnePost($id){
        $post = Post::where('deleted', 0)->find($id);
        if (!$post) {
            return response()->json(['status' => 'error', 'data' => 'Post does not exist!'], 404);
        } else {
            $post['categories'] = $this->stringToArray($post['categories']);

            return response()->json(['status' => 'ok', 'data' => $post], 200);
        }
    }

    public function createPost(Request $request){
        $title = $request->get('title');
        $link = $request->get('link');
        $description = $request->get('description');
        $author = $request->get('author');
        $categories = $request->get('categories');
        $date = $request->get('date');

        if(!$title || !$link || !$description || !$author || !$categories || !$date){
            return response()->json(['status' => 'error', 'data' => 'Enter all required data!'], 400);
        }elseif(!$this->validateDate($date)){
            return response()->json(['status' => 'error', 'date' => 'Enter the right format of date. Example: 2021-02-02 12:00:00'], 400);
        }else{
            try {
                //We create a unique slug
                while(true){
                    $slug = rand(8000000000, 9000000000);

                    if(!Post::where('deleted', 0)->where('slug', $slug)->first())
                        break;
                }

                $post = new Post([
                    'slug' => $slug,
                    'title' => $title,
                    'link' => $link,
                    'description' => $description,
                    'author' => $author,
                    'categories' => $categories,
                    'date' => $date
                ]);
                $post->save();

                return response()->json(['status' => 'ok', 'data' => ''], 200);
            }catch (Exception $ex){
                return response()->json(['status' => 'error', 'data' => 'An error occurred while creating the post'], 500);
            }
        }
    }

    public function updatePost($id, Request $request){
        $post = Post::where('deleted', 0)->find($id);

        if($post) {
            if ($request->exists('title')) {
                $post->update(['title' => $request->get('title')]);
            } if ($request->exists('link')) {
                $post->update(['link' => $request->get('link')]);
            } if ($request->exists('description')){
                $post->update(['description' => $request->get('description')]);
            } if($request->exists('author')) {
                $post->update(['author' => $request->get('author')]);
            } if($request->exists('categories')) {
                $post->update(['categories' => $request->get('categories')]);
            } if($request->exists('date')){
                if(!$this->validateDate($request->get('date'))){
                    return response()->json(['status' => 'error', 'date' => 'Enter the right format of date. Example: 2021-02-02 12:00:00'], 400);
                }else{
                    $post->update(['date' => $request->get('date')]);
                }
            }

            $post->save();
            return response()->json(['status' => 'ok', 'data' => ''], 200);
        }else{
            return response()->json(['status' => 'error', 'data' => 'Post does not exist'], 404);
        }
    }

    public function deletePost($id){
        $post = Post::where('deleted', 0)->find($id);

        if($post){
            $post->update(['deleted' => 1]);
            $post->save();
            return response()->json(['status' => 'ok', 'data' => ''], 200);
        }else{
            return response()->json(['status' => 'error', 'data' => 'Post doest not exist'], 404);
        }
    }
}
