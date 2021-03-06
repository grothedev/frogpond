<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Illuminate\Http\Request;
use App\Models\Croak;

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
        $ip = encrypt( \Request::getClientIp(true) );

        $croak = Croak::findOrFail($req->croak_id);
        if (is_null($croak)) {
            return [
                'error' => 'croak not found: ' . $req->croak_id
            ];
        }

        $votes = Vote::where('croak_id', '=', $req->croak_id)->get()->toArray();

        foreach ($votes as $v){
            if ( decrypt($v['ip']) == \Request::getClientIp(true) ) {
                return [
                    'error' => 'this ip address has already voted on this croak'
                ];
            }
        }

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
