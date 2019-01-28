<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::all();
        return $files;
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
        $files = $request->file('f');
        $success = array(); //each file success


        $dst = 'f'; //keepin it simple


        if (!is_array($files)) { //make it into a 1 elem array
          $tmp = array();
          array_push($tmp, $files);
          $files = $tmp;
        }

        foreach ($files as $f){
          $fObj = new File();
          $fObj->filename = $f->getClientOriginalName();
          $fObj->path = $dst . '/' . $f->getClientOriginalName();
          $fObj->filesize = $f->getSize();

          $s = $fObj->save();

          $m = $f->move($dst,$f->getClientOriginalName());

          if ($s && !is_null($m)) array_push($success, 1);
          else array_push($success, 0);

        }


        return $success;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return File::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
