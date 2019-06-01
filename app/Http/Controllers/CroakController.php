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

        $i = 0;
        foreach($croaks as $c){
          $c['tags'] = $c->tags()->get();
          if ($c->files()) $c['files'] = $c->files()->get();
          $i++;
        }

        if ( isset($req->tags) ){
          //tags query param is a string with each tag label separated by a space
          $r_tags = explode(',', $req->tags);

          $m = 0; //croaks associated with any (0) or all (1) of these tags
          if (isset($req->mode)) $m = $req->mode;

          foreach($croaks as $c){
            $c_tags = $c->tags()->get();
            if ($m==0){
              foreach($c_tags as $t){
                if (in_array($t->label, $r_tags)){ //if this croak tag matches any request tag
                  array_push($result, $c);
                  continue;
                }
              }
            } else {
              $include = true;
              foreach($r_tags as $rt){
                for($i = 0; $i < sizeof($c_tags); $i++){
                  if ($c_tags[$i]->label === $rt) break;
                  if ($i == sizeof($c_tags)-1){
                    $include = false; //none of the tags of this croak matched one of the request tags, therefore this croak cannot be included
                    break 2;
                  }
                }
              }
              if ($include) array_push($result, $c);
            }
          }
        } else {
          $result = $croaks->toArray();
        }

        if (isset($req->radius) && isset($req->x) && isset($req->y)){
          for ($i = 0; $i < sizeof($result); $i++){
            $c = $result[$i];
            var_dump($c);
            if ( abs( (int)$c['x'] * (int)$c['x'] + (int)$c['y'] * (int)$c['y']) > (int)$req->radius * (int)$req->radius ){
              //print($c['x'] . ' ' . $c['id'] . '\n');
              unset($result[$i]);
            }
          }
        }

        if (isset($req->p_id)){
          for ($i = 0; $i < sizeof($result); $i++){
            if ($result[$i]['p_id'] != $req->p_id){
              unset($result[$i]); //does i need to be decremented also?
            }
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
      if (!isset($request->type)){
        $c->type = 0;
      }
      if (isset($request->p_id)){
        $c->p_id = $request->p_id;
      }
      $c->ip = \Request::getClientIp(true);
      $c->content = $request->content;
      $c->fade_rate = .6;
      $c->score = 0;

      /*
      if (Auth::guest()){
        //post anonymously
      } else {

      }
      */

      $saved = null;
      if ($saved = $c->save()){
        $tags = explode(',', $request->tags);
        foreach( $tags as $tag){
          $tid = Tag::firstOrCreate(['label' => $tag])['id'];
          $t = Tag::findOrFail($tid);
          $t->refs += 1;
          $t->save();
          $c->tags()->attach($tid);
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
