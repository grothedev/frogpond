<?php

namespace App\Http\Controllers;

use App\Croak;
use App\Tag;
use App\File;
use Illuminate\Http\Request;

class CroakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $result = array();
        $croaks = Croak::all();
        if ( isset($req->tags) ){
          echo json_decode($req->tags);
          $m = 0; //croaks associated with any (0) or all (1) of these tags
          if (isset($req->mode)) $m = $req->mode;

          foreach($croaks as $c){
            $c_tags = $c->tags()->get();
            foreach($c_tags as $t){
              if (in_array($t->label, $req->tags)){
                array_push($result, $c);
              }
            }
          }
          array_push($result, 'asdflkn');
        } else {

          //$tags = Tag::all();
          //$result = $croaks->toArray();
          $result = $croaks->toArray();

          $i = 0;
          foreach($croaks as $c){
            $result[$i]['tags'] = $c->tags()->get();
            if ($c->files()) $result[$i]['files'] = $c->files()->get();
            $i++;
          }
        }

        //return $croaks;
        return $result;
    }

    public function attachFilesTags($croak){
      $result = array();

      $result['tags'] = $croak->tags()->get();
      if ($croak->files()) $result['files'] = $croak->files()->get();

      return $result;
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

      /*
      if (Auth::guest()){
        //post anonymously
      } else {

      }
      */

      $saved = null;
      if ($saved = $c->save()){
        $tags = explode(' ', $request->tags);
        foreach( $tags as $tag){
          $t = Tag::firstOrCreate(['label' => $tag]);
          $c->tags()->attach($t['id']);
        }


        $files = $request->file('f');
        $dst = 'uploaded_files';
        if (!is_null($files)){
          foreach($files as $f){
            $file = File::firstOrCreate(['filename' => $f->getClientOriginalName(), 'path' => $dst . '/' . $f->getClientOriginalName(), 'filesize' => $f->getSize()]);
            $c->files()->attach($file['id']);
          }
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
        $croak = Croak::findOrFail($id);
        $result = $croak->toArray();
        $result['tags'] = $croak->tags()->get();
        if ($croak->files()) $result['files'] = $croak->files()->get();
        return $result;
        //return CroakController::attachFilesTags($croak);
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
