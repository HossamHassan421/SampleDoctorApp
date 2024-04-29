<?php

namespace App\Services;


use App\Exceptions\CustomException;
use App\Models\Image;
use Illuminate\Validation\ValidationException;
use File;

class BaseService
{

    protected static $paginateNumber = 20;

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

    protected static function validateSlug($slug)
    {
        $pattern = '/^[a-zA-Z0-9-_]+$/';
        $flag = preg_match($pattern, $slug);
        if (!$flag) {
            throw ValidationException::withMessages(['slug' => 'slug is not valid']);
        }

        return $flag;
    }

    protected static function validateYoutubeLink($link)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        $flag = preg_match($pattern, $link);
        if (!$flag) {
            throw ValidationException::withMessages(['link' => 'link is not valid']);
        }

        return $flag;
    }

    protected static function copyDocument($document, $newPath)
    {
        if (\File::exists($document)) {
            $filename = basename($document);
            \File::ensureDirectoryExists($newPath);
            $path = public_path($newPath . $filename);
            $success = \File::copy(public_path($document), $path);
            if ($success) {
                return $newPath . $filename;
            }
        }
        return false;
    }

    protected static function randomPasswordGenerator($len = 8)
    {
        if ($len < 8)
            $len = 8;
        //define character libraries - remove ambiguous characters like iIl|1 0oO
        $sets = array();
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        $sets[] = '123456789';
        $sets[] = '@#$_-';

        $password = '';
        //append a character from each set - gets first 4 characters
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
        }
        //use all characters to fill up to $len
        while (strlen($password) < $len) {
            //get a random set
            $randomSet = $sets[array_rand($sets)];
            //add a random char from the random set
            $password .= $randomSet[array_rand(str_split($randomSet))];
        }
        //shuffle the password string before returning!
        return str_shuffle($password);
    }
}
