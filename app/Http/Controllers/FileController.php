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
        $MAX_FILESIZE = 512000000; //512 MB
        $files = $request->file('f');
        $res = array(); //[success, filename, msg] response for each file


        $dst = 'f'; //keepin it simple


        if (!is_array($files)) { //make it into a 1 elem array
          $tmp = array();
          array_push($tmp, $files);
          $files = $tmp;
        }

        foreach ($files as $f){
          $fObj = new File();
          $fObj->filename = $f->getClientOriginalName();
          
          //checking filesize
          $fObj->filesize = $f->getSize();
          if ($fObj->filesize > $MAX_FILESIZE){
            array_push($res, ['filename' => $fObj->filename, 'success' => false, 'msg' => 'file too big (>512MB). contact me for special cases']);
            continue;
          }

          //checking duplicate filename
          while (File::where('filename', $fObj->filename)->first() != null){
            $fObj->filename = rand() . '_' . $f->getClientOriginalName();
          }
          $fObj->path = $dst . '/' . $fObj->filename;

          try {
            $s = $fObj->save();
          } catch (Exception $e){
            return $e;
          }
          $m = $f->move($dst,$fObj->filename);
          
          if ($s && !is_null($m)) array_push($res, ['filename' => $fObj->filename, 'success' => true] );
          else array_push($res, ['filename' => $fObj->filename, 'success' => false, 'msg' => 'upload failed: php filesystem interaction error'] );

        }


        return json_encode($res);
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
