<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vote;
use App\Croak;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vote::all()->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $ip = \Request::getClientIp(true);
        $croak = Croak::findOrFail($req->croak_id);
        $dupe = Vote::where('ip', '=', $ip)->where('croak_id', '=', $req_croak_id)->first();
        var_dump($dupe);

        if (is_null($croak)) return -1;

        if (is_null($dupe)){
            $v = new Vote();
            $v->ip = $ip;
            $v->croak_id = $req->croak_id;
            if ($req->v == 0) {
                $v->v = false;
                $croak['score'] -= 1;
            } else {
                $v->v = true;
                $croak['score'] += 1;
            }
            $v->save();
            $croak->save();
        }
        return $croak['score'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Vote::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
