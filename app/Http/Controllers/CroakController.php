<?php

namespace App\Http\Controllers;

use App\Croak;
use App\Tag;
use Illuminate\Http\Request;

class CroakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = Croak::all()->toArray();
        return $c;
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

      $c = new Croak();
      $c->type = $request->type;
      if (!isset($request->x) || !isset($request->y)){
        $c->x = $c->y = 0;
      } else {
        $c->x = $request->x;
        $c->y = $request->y;
      }

      $c->ip = \Request::getClientIp(true);
      $c->content = $request->content;
      $c->fade_rate = .6;

      if (Auth::guest()){
        //post anonymously
      } else {

      }

      $saved = null;
      if ($saved = $c->save()){
        $tags = $request->tags;
        foreach( $tags as $tag){
          $t = Tag::firstOrCreate(['tag' => $tag]);
          $c->tags()->attach($t['id']);
        }
        return 0;
      } else {
        return $saved;
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Croak::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
