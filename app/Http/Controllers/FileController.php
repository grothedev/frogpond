<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if (isset($req->tag)){
          return File::where('tag', '=', $req->tag)->get();
        } else {
          return File::all();
        }
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
     * upload some files
     * required params:
     *  f: POST files (multipart). file/s to upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //is this a chunked upload or not?
        if ($request->chunked && $request->chunked = true){ //TODO add chunked files to the database
          //store this chunk in tmp storage. if tmp storage contains # of chunks as total of this session id, merge them and move to destination
          $data = $request->file('file_chunk');
          $id = $request->session_id;
          $folder = 'filechunks/'.$request->filename.'_'.$id.'/'; //where this file will be stored
          $m = $data->move($folder, $request->filename.'-'.$request->chunk_id);
          $percent_complete = ((sizeof(scandir($folder))-2) / $request->total_chunks)*100; // -2 because '.' & '..'
          if ($m && $percent_complete == 100){
            $dstFile = fopen('f/'.$request->filename, 'wb');
            for ($i = 0; $i < $request->total_chunks; $i++){
              $chunkFilename = $folder.$request->filename.'-'.$i;
              $chunkFile = fopen($chunkFilename, 'a+');
              fwrite($dstFile, fread($chunkFile, filesize($chunkFilename)));
              unlink($chunkFilename);
            }
            fclose($dstFile);
            return [
              'session_id' => $id,
              'chunk_id' => $request->chunk_id,
              'success' => true,
              'percent' => 100,
              'filepath' => 'f/'.$request->filename
            ];  
          }
          return [
            'session_id' => $id,
            'chunk_id' => $request->chunk_id,
            'success' => $m,
            'percent' => $percent_complete
          ];
        } else {        
          $MAX_FILESIZE = 536870912; //512 MB
          $files = $request->file('f');
          $res = array(); //[success, filename, msg] response for each file

          //return var_dump($request->toArray());
          $dst = 'f'; //keepin it simple

          if (!is_array($files)) { //make it into a 1 elem array
            $tmp = array();
            array_push($tmp, $files);
            $files = $tmp;
          }

          
          foreach ($files as $i => $f){
            $res[$i] = var_dump($f);
            
            $fObj = new File();
            continue;
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
            
            //all files uploaded in this request will have the same tag that is only of concern to the uploader. this is not the same thing as a croak tag
            if (isset($request->tag)){
              $fObj->tag = $request->tag;
            }

            try {
              $s = $fObj->save();
            } catch (Exception $e){
              return $e;
            }
            $m = $f->move($dst,$fObj->filename);


            if ($s && !is_null($m)) array_push($res, ['filename' => $fObj->filename, 'url' => "http://grothe.ddns.net/f/" . $fObj->filename, 'success' => true] );
            else array_push($res, ['filename' => $fObj->filename, 'success' => false, 'msg' => 'upload failed: php filesystem interaction error'] );

          }


          return json_encode($res);
        }
    }

	//go through all files in the upload dir ('f') and add them to the database as a file object if they are not already added
	function populateDB(Request $request){
		$pass = $request->pass;
		if ($pass != env('ADMIN_PASS') ) return 'wrong password';

		$filenames = scandir('f');
		//var_dump($filenames);
		foreach ($filenames as $fn){
			if (File::where('filename', $fn)->first() != null) continue; //file already in DB

			//get file data then make new file obj on db
			$f = new File();
			$f->path = 'f/' . $fn;
			$f->filesize = filesize('f/' . $fn);
			$f->filename = $fn;
			if ($f->save() ) print($fn . ' saved <br>');

		}
		return 0;
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
