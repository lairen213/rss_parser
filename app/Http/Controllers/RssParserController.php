<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Vedmant\FeedReader\Facades\FeedReader;

class RssParserController extends Controller
{
    private $parse_link = 'https://lifehacker.com/rss';

    public function parseRss(){
        try {
            //Parse the rss site
            $f = FeedReader::read($this->parse_link);
            $isAdded = false;

            //Going through all items
            foreach ($f->get_items(0, $f->get_item_quantity()) as $item) {

                //Check there is already such an post in the database, if not, then add
                $post = Post::where('slug', $item->get_id())->first();
                if(!$post){
                    //Parse categories from array to string with separator
                    $categories = '';
                    foreach($item->get_categories() as $category){
                        $categories .= "&".$category->term;
                    }

                    $post = new Post([
                        'slug' => $item->get_id(),
                        'title' => $item->get_title(),
                        'description' => $item->get_description(),
                        'link' => $item->get_link(),
                        'author' => $item->get_authors()[0]->name,
                        'categories' => $categories,
                        'date' => date("Y-m-d H:i:s", strtotime($item->get_date()))
                    ]);
                    $post->save();

                    $isAdded = true;
                }

            }

            //data
            //true = new post was added, false = nothing was added
            return response()->json(['status' => 'ok', 'data' => $isAdded], 200);
        }catch (Exception $ex){
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 500);
        }
    }
}
