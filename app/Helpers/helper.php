<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Archivo;
use \CloudConvert\Api;
use \CloudConvert\Process;

class Helper
{
    public static function getImage(Archivo $archivo)
    {

        $imagedata = file_get_contents(route("archivo", $archivo->nombre));

        $base64 = base64_encode($imagedata);

        return 'data:'.$archivo->tipo.';base64,'.$base64;

        //return route("archivo", $archivo->nombre);
        
    }
    public static function getPdf(Archivo $archivo, $token)
    {

        return url('/pdf/viewer.html?file=').urlencode(route('archivo.pdf', ["filename"=>$archivo->version_pdf, "token"=>$token]));
        
    }

    public static function pdfToJpg($nombre)
    {

		$base = basename($nombre, ".pdf");

		$api = 'https://v2.convertapi.com/pdf/to/jpg?download=inline&Secret=1ZxFIfKjBV0C2M9D&file='.urlencode('http://fabricadesoftwareperu.com/archivo/').$nombre;

		copy($api, storage_path("archivos/".$base.'.jpg'));
        
    }



    public static function toPdf(Archivo $archivo)
    {

        $temp = explode( '.', $archivo->nombre );
        $ext = array_pop( $temp );
        if($ext=="pdf"){


            $archivo->fill(["version_pdf" => $archivo->nombre])->save();    


        }else{


            $api = new Api(config("admin.cloudconvert.key"));


            $process = $api->createProcess([
                'inputformat' => $ext,
                'outputformat' => 'pdf',
            ]);

            $process->start([
                'outputformat' => 'pdf',
                'input' => 'download',
                'file' => route('archivo', $archivo->nombre),
                'callback' => route('archivo.pdf.callback', $archivo->id)
            ]);




        }

        
    }


    public static function toThumbnail(Archivo $archivo)
    {

        $temp = explode( '.', $archivo->nombre );
        $ext = array_pop( $temp );
        $name = implode( '.', $temp );

    
        $api = new Api(config("admin.cloudconvert.key"));

        $process = $api->createProcess([
                'inputformat' => $ext,
                'outputformat' => 'jpg',
                "converteroptions" => [
                    "page_range" => "1",
                    "quality" => "70",
                    "density" => "300",
                    "resize" => "200x200",
                    "resizemode" => "crop",
                    "disable_alpha" => true,
                    "hidden_slides" => null,
                    "input_password" => null,
                ]
            ]);

        $process->start([
                "inputformat" => $ext,
                "outputformat" => "jpg",
                "input" => "download",
                "file" => route('archivo', $archivo->nombre),
                "converteroptions" => [
                    "resize" => "200x200",
                    "resizemode" => "maximum",
                    "resizeenlarge" => null,
                    "rotate" => null,
                    "quality" => "70",
                    "grayscale" => null,
                    "density" => "300",
                    "page_range" => "1-1",
                    "disable_alpha" => true,
                    "strip_metatags" => null,
                    "command" => null
                ],
                'callback' => route('archivo.thumbnail.callback', $archivo->id)
        ]);


    }

    public static function compressImage($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

        //save file
        imagejpeg($image, $destination_url, $quality);

        //return destination file
        return $destination_url;
    }

    public static function getDate($mysqlDate){

        $phpdate = strtotime( $mysqlDate );
        return date( config("fecha.formato"), $phpdate );

    }

}