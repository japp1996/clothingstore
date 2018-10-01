<?php
namespace App\Libraries;

class SetNameImage
{
    public static function set($name, $extension)
    {
        // replace slash
        $name = str_replace('/', '', bcrypt($name.Date('Y-md').rand(155648,849854521563)));
        // replace point
        $name = str_replace('.', '', $name);

        return $name . '.' . $extension;
    }
}