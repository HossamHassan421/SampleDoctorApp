<?php

namespace App\Services\Doctor;




class BaseService
{

    protected static function uploadImage($image, $path = 'uploads/images', $old = null)
    {
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($path), $imageName);
        $result = $path . '/' . $imageName;
        if ($old != null && is_file(public_path($old)) && file_exists(public_path($old))) {
            unlink($old);
        }
        return $result;
    }

}
