<?php

namespace App\Http\Controllers;

use \CloudConvert\Api;
use \CloudConvert\Process;
use Illuminate\Http\Response;
use App\Archivo;
use App\Apunte;


class ArchivosController extends Controller {

	public function getFile($filename)
	{
		if(is_file ( storage_path("archivos/".$filename) ) ){
			return response()->download(storage_path("archivos/".$filename), null, [], null);
		}
	}

	public function getImage($filename)
	{
		if(is_file ( storage_path("thumbnails/".$filename) ) ){
			return response()->download(storage_path("thumbnails/".$filename), null, [], null);
		}
	}

	public function getFileToken($filename, $token)
	{

		$ts = session()->pull("token", 'nada');

		if($ts==$token){

			return response()->download(storage_path("archivos/".$filename), null, ['Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0'], null);

		}
	}


	public function pdfCallback($id)
	{

		$archivo = Archivo::where('id', $id)->first();

		$temp = explode( '.', $archivo->nombre );
		$ext = array_pop( $temp );
		$name = implode( '.', $temp );

		$api = new Api(config("admin.cloudconvert.key"));

		$process = new Process($api, $_REQUEST['url']);
		$process->refresh()->download(storage_path("archivos/".$name.".pdf"));
	
        $archivo->fill(["version_pdf" => $name.".pdf"])->save();		

	}


	public function thumbnailCallback($id)
	{

		$archivo = Archivo::findOrFail($id);

		$apunte = Apunte::findOrFail($archivo->apunte_id);

		$temp = explode( '.', $archivo->nombre );
		$ext = array_pop( $temp );
		$name = implode( '.', $temp );

		$api = new Api(config("admin.cloudconvert.key"));

		$process = new Process($api, $_REQUEST['url']);
		$process->refresh()->download(storage_path("thumbnails/".$name.".jpg"));
	
        $apunte->fill(["thumbnail" => $name.".jpg"])->save();		

	}

}