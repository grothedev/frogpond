<?php

namespace App\Http\Controllers;

use App\Models\Croak;
use App\Models\Tag;
use App\Models\File;
use App\Models\Report;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CroakController extends Controller
{
      /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index(Request $req)
      {
              //global $result;
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

          if (isset($req->x) && isset($req->y)){
            $rad = 0;
            if (isset($req->radius)) $rad = $req->radius;

            $s = sizeof($result);
            $newresult = array();
            for ($i = 0; $i < $s; $i++){
              $c = $result[$i];
              $latA = $req->y * pi()/180.0;
              $lonA = $req->x * pi()/180.0;
              $latB = decrypt($c['y']) * pi()/180.0;
              $lonB = decrypt($c['x']) * pi()/180.0;
              $dist = acos( sin($latA) * sin($latB) + cos($latA) * cos($latB) * cos($lonA - $lonB) ) * 6371; //km

              //echo 'Crk ' . $c['id'] . ': ' . $dist . ' ';

              //echo $dist . '<br>';
              if ($rad == 0 || $dist < (int) $rad + 20){
                $result[$i]['distance'] = $dist;
                array_push($newresult, $result[$i]);
              }
            }
            $result = $newresult;
          }

          $res1 = Array();
          if (isset($req->exclude)){
            $excluded = explode(',', $req->exclude);
            for($i = 0; $i < sizeof($result); $i++){
              for ($j = 0; $j < sizeof($result[$i]['tags']); $j++){
                foreach ($excluded as $x){
                  if ($result[$i]['tags'][$j]['label'] == $x){
                    break 2;
                  }
                }
                if ($j == sizeof($result[$i]['tags'])-1) array_push($res1, $result[$i]);
              }

            }
            $result = $res1;
          }


          //TODO later: comment croaks by radius
              $res2 = Array(); //i'm starting to see why people hate php now
          if (isset($req->p_id)){

            //put all p_id ints into an array whether there is one given or multiple as string separated by commas
            $pids = explode(',', $req->p_id);

            foreach ($pids as $pid){
              for ($j = 0; $j < sizeof($result); $j=$j+1){
                if ($result[$j]['p_id'] != null && $result[$j]['p_id'] == $pid){
                  array_push($res2, $result[$j]);
                  //continue;
                } else if ($result[$j]['p_id'] == null && $pid <= 0 ){ //requesting root croaks
                  array_push($res2, $result[$j]);
                }
                //both unset and array_splice did not work properly
                //unset($result[$j]);
                //$result = array_splice($result, $j, 1);
              }
            }
            $result = $res2;
          }

          if (isset($req->n) && is_numeric($req->n)){
            $result = array_slice($result, 0, $req->n);
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
      public function create(FormBuilder $fb)
      {
          $form = $fb->create(\App\Forms\CroakForm::class, [
            'method' => 'POST',
            'url' => route('croak.store')
          ]);

          return view('croak.create', compact('form'));
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
        $tags = explode(',', $request->tags);
        if (sizeof($tags) > 14) return -1; //too many tags

        //lat and lon
        if (!isset($request->x) || !isset($request->y)){
          $c->x = $c->y = 0;
        } else {
          $c->x = encrypt( $request->x );
          $c->y = encrypt( $request->y );
        }

        //croak type, currently unused
        if (!isset($request->type)){
          $c->type = 0;
        } else {
          $c->type = $request->type;
        }

        //setting parent id, if this is a comment, otherwise parent id = 0
        if (isset($request->p_id)){
          $c->p_id = $request->p_id;
          if ($c->p_id != 0){
            $p = Croak::find($c->p_id);
            if (is_null($p)) return -1;
            $p->replies += 1;
            $p->save();
          }
        } else {
          $c->p_id = NULL;
        }

        $c->ip = encrypt( \Request::getClientIp(true) );
        $c->content = $request->content;
        $c->fade_rate = .6;
        $c->score = 0;

        /*
        if (Auth::guest()){
          //post anonymously
        } else {

        }
        */

        if ($c->save()){

          foreach( $tags as $tag){
            $tid = Tag::firstOrCreate(['label' => $tag])['id'];
            $t = Tag::findOrFail($tid);
            $t->refs += 1;
            $t->save();
            $c->tags()->attach($tid);
          }


          $files = $request->file('f');
          $dst = 'f';
          if (!is_null($files)){
            foreach($files as $f){
              $file = File::firstOrCreate(['filename' => $f->getClientOriginalName(), 'path' => $dst . '/' . $f->getClientOriginalName(), 'filesize' => $f->getSize()]);
              $f->move($dst, $file->filename);
              /*
              if ($file == null || sizeof($file)==0){
                $file = File::create(['filename' => $f->getClientOriginalName(), 'path' => $dst . '/' . $f->getClientOriginalName(), 'filesize' => $f->getSize()]);
                $f->move($dst,$file->filename);
              } else {
                $file = $file->first();
              } */
              $c->files()->attach($file['id']);
            }
          }

          $result = $c->toArray();
          $result['tags'] = $c->tags()->get();
          if ($c->files()) $result['files'] = $c->files()->get();
          if (isset($request->redirect)){
            return redirect()->back();
          } else {
            return $result;
          }
        } else {
            if (isset($request->redirect)){
                return redirect()->back();
            } else {
                return -1;
            }
        }
      }

      //for read-only web view (not api)
      public function roView($id){
          $c = Croak::findOrFail($id);
          return view('c', compact('c'));
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

      public function report(Request $req){
        $ip = encrypt( \Request::getClientIp(true) );
        $croaks = Report::where('croak_id', '=', $req->croak_id)->get();
        foreach ($croaks as $c){
          if ( decrypt( $c->ip ) == \Request::getClientIp(true) ) return -1;
        }

        $c = Croak::findOrFail($req->croak_id);
        if (is_null($c)) return -1;

        $r = new Report();
        $r->ip = $ip;
        $r->croak_id = $req->croak_id;
        $r->reason = $req->reason;
        $c['reports'] += 1;
        $r->save();
        $c->save();

        return $c['reports'];
      }

      public function map(){
        //todo get croaks from query
        $cs = Croak::all()->take(5);
        foreach ($cs as $c){
          $c->x = decrypt($c->x);
          $c->y = decrypt($c->y);//NOTE: i shouldn't leave this in production
        }
        return view('map', compact('cs'));
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  \App\Post  $post
       * @return \Illuminate\Http\Response
       */
      public function edit(Croak $c)
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
      public function update(Request $request, Croak $c)
      {
          //
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Post  $post
       * @return \Illuminate\Http\Response
       */
      public function destroy(Croak $c)
      {
          //
      }
}
