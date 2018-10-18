<?php
namespace App\Libraries;

use Intervention\Image\ImageManagerStatic as Images;

class ResizeImage 
{
    public static function dimenssion($file, $ext, $route)
    {
        // REDIMENSION DE LAS IMAGENES
        $dimensiones = getimagesize(public_path($route.$file));
        $width = $dimensiones[0];
        $height = $dimensiones[1];
     
        $resizer = Images::make(public_path($route.$file));
        
        $porcentaje = 20;
        $d_width = $dimensiones[0];
        if($d_width > 3100){
            $porcentaje = 50;
        }else if($d_width > 2000 && $d_width < 3100){
            $porcentaje = 60;
        }else if($d_width > 1300 && $d_width < 2000){
            $porcentaje = 70;
        }
        if ($ext == 'png'){
            if($d_width > 3100){
                $porcentaje = 60;
            }else if($d_width > 2000 && $d_width < 3100){
                $porcentaje = 50;
            }else if($d_width > 1300 && $d_width < 2000){
                $porcentaje = 30;
            } else if ($d_width < 1024) {
                $porcentaje = 5;
            }
            $porcentaje = $porcentaje / 100;
            $width = $dimensiones[0] - ($dimensiones[0] * $porcentaje);
            $height = $dimensiones[1] - ($dimensiones[1] * $porcentaje);
            $resizer->resize($width, $height)->save(public_path($route.$file), $porcentaje);
        }elseif ($ext == 'jpg'){
            $resizer->resize($width, $height)
            ->save(public_path($route.$file), $porcentaje);
        }
    }
}
