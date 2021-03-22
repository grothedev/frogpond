<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Croak;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::all()->toArray();
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
        $c = Croak::findOrFail($req->croak_id);
        $dupe = Report::where('ip', '=', $ip)->where('croak_id', '=', $c->id)->first();

        if (is_null($c)) return -1;
        if (is_null($dupe)){
            $r = new Report();
            $r->ip = $ip;
            $r->croak_id = $req->croak_id;
            $r->reason = $req->reason;
            $c['reports'] += 1;
            $r->save();
            $c->save();
        }
        return $c['reports'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Report::find($id);
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
