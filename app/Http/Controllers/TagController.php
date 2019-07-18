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

      $tags = Tag::all();

      if (isset($request->radius) && isset($request->x) && isset($request->y) ){
        $lonA = $request->x * pi()/180.0; 
        $latA = $request->y * pi()/180.0;

        for ($i = 0; $i < sizeof($tags); $i++){
          $cks = $tags[$i]->croaks()->get();
          foreach ($cks as $c){ //better idea: each tag should have a list of locations associated with it that is updated upon each croak submit
            $latB = $c['y'] * pi()/180.0;
            $lonB = $c['x'] * pi()/180.0;
            $dist = acos( sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($lonA - $lonB) ) * 6371; //km
            if ( $dist < (int)$request->radius + 20){ //add to account for error
              continue 2; //tag has a croak that is within range, so check next tag
            }
            if ($i = sizeof($tags) - 1) unset($tags[$i]);
          }
          
        }
      }

      if (isset($request->n)){
        //$tags = DB::table('tags')->orderBy('refs', 'desc')->take((int)$request->n)->get();
        $tags = $tags->sortByDesc('refs')->take((int)$request->n);
      } else {
        $tags = Tag::all();
      }

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
