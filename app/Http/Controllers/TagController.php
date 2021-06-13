<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Croak;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a list of tags.
     * optional params:
     *  x, y: float. logitude, latitude. 
     *  radius: int. search radius in km. requires x & y.
     *  n: int. maximum number of tags to return.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $tags = Tag::all();

      if (isset($request->x) && isset($request->y) ){
        $radius = 20; //default radius if not set
        if (isset($request->radius)){
          $radius = $request->radius;
        }

        $lonA = $request->x * pi()/180.0;
        $latA = $request->y * pi()/180.0;

        for ($i = 0; $i < sizeof($tags); $i++){
          $cks = $tags[$i]->croaks()->get();
          foreach ($cks as $c){ //better idea: each tag should have a list of locations associated with it that is updated upon each croak submit
            $latB = decrypt($c['y']) * pi()/180.0;
            $lonB = decrypt($c['x']) * pi()/180.0;
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
        $tags = array_values($tags->sortByDesc('refs')->take((int)$request->n)->all());
     } else {
        $tags = $tags->toArray();
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
