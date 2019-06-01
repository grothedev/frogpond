<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Croak;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

		$tags; // = Tag::all();

		if (isset($request->n)){
			$tags = DB::table('tags')->orderBy('refs', 'desc')->take((int)$request->n)->get();
		} else {
			$tags = Tag::all();
		}

		/* TODO get tags within a radius
      if (isset($request->radius) && isset($request->x) && isset($request->y) ){
        $rx = $request->x; $ry = $request->y;
        $croaks = Croak::all();


        for ($i = 0; $i < sizeof($croaks); $i++){
            $c = $croaks[$i];
            if (abs($c->x * $c->x + $c->y * $c->y - ($rx*$rx + $ry*$ry)) > $request->radius * $request->radius ){
                unset($croaks[$i]);
                echo $c->content;
            }
        }

        return $croaks;
        //then find the top n most used tags of those posts
        foreach($croaks as $c){
            $tags = $c->tags();

        }
        /*
        for ($i = 0; $i < sizeof($tags); $i++){

        }
        */

        return $tags;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
