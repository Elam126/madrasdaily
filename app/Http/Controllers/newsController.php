<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\news;

class newsController extends Controller
{
    public function index(Request $request){
       $newsapp = news::all();
        //return $newsapp;
        return \Response::json([
            //'message' => $newsapp
            'data' => $this->transformCollection($newsapp)
       ], 200); 

      
    }

    public function show($id){
        $newsapp = news::find($id);

        if(!$newsapp){
            return \Response::json([
                'error' => [
                    'message' => 'News does not exist'
                ]
            ], 404);
        }

        return \Response::json([
            'data' => $this->transform($newsapp)
        ], 200);
    }

    private function transformCollection($newsapp){
       return array_map([$this, 'transform'], $newsapp->toArray());
    }
    
    private function transform($newsapp){
        return [
               'news_id' => $newsapp['id'],
               'heading' => $newsapp['title'],
               'news_type' => $newsapp['catagory'],
               'news_content' => $newsapp['body']
            ];
    }

    public function store(Request $request)
    {

        if(! $request->title){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide proper value to Insert the News'
                ]
            ], 422);
        }
        $newsapp = news::create($request->all());

        return \Response::json([
                'message' => 'News Created Succesfully',
                'data' => $this->transform($newsapp)
        ]);
    }

    public function update(Request $request)
    {
        if(! $request->title){
            return \Response::json([
                'error' => [
                    'message' => 'Please Provide proper value to Update the existing News'
                ]
            ], 422);
        }

        //$newsapp = Joke::find($id);
        $newsapp->news_id = $request->news_id;
        $newsapp->heading = $request->heading;
        $newsapp->news_type = $request->news_type;
        $newsapp->news_content =$request->news_content;


        //$newsapp->user_id = $request->user_id;
        $newsapp->save();

        return \Response::json([
                'message' => 'News Updated Succesfully'
        ]);
    }

    public function destroy($news_id)
    {
        news::destroy($news_id);
    }
}