<?php

/**
 * Custom Helper class
 *
 * @author Bobur Nuridinov <bobnuridinov@gmail.com>
 */

namespace App\Support\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Image;

class Helper
{
    public static function generateSlug($string): string
    {
        $transilation = self::transliterateIntoLatin($string);

        // remove unwanted characters
        $transilation = preg_replace('~[^-\w]+~', '', $transilation);

        // remove duplicate dividers
        $transilation = preg_replace('~-+~', '-', $transilation);

        $transilation = trim($transilation, '-');
        $slug = strtolower($transilation);

        return $slug;
    }

    /**
     * Generate unique slug for the given model
     *
     * @param string $string Generates slug from given string
     * @param string $model Model Classname with full namespace
     * @param integer $ignoreId ignore slug of a model with a given id (used while updating model)
     * @return string
     */
    public static function generateUniqueSlug($string, $model, $ignoreId = null)
    {
        $slug = self::generateSlug($string);

        // escape duplicate slug
        $counter = 1;
        $originalSlug = $slug;

        while ($model::where('slug', $slug)->where('id', '!=', $ignoreId)->first()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Rename file, if file with a given name is already exists in the path
     * Renaming style name(i++)
     *
     * @param string $filename
     * @param string $path
     */
    public static function escapeDuplicateFilename($filename, $path): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $path = $path . '/';

        $originalName = $name;
        $counter = 1;

        while (file_exists($path . $filename)) {
            $name = $originalName . '(' . $counter . ')';
            $filename = $name . '.' . $extension;
            $counter++;
        }

        return $filename;
    }

    /**
     * Upload models file & update models column
     *
     * @param \Eloquent\Model\ $model
     * @param string $inputName - Requested file input name and Models column name
     * @param string $filename
     * @param string $storePath
     * @return string uploaded file path
     */
    public static function uploadModelsFile($model, $inputName, $fileName, $storePath): string
    {
        $file = request()->file($inputName);
        $fileName = self::cutAndTrim($fileName, 60);
        $fileFullName = $fileName . '.' . $file->getClientOriginalExtension();
        $fileFullName = self::escapeDuplicateFilename($fileFullName, $storePath);

        $file->move($storePath, $fileFullName);
        $model->{$inputName} = $fileFullName;
        $model->save();

        return $storePath . '/' . $fileFullName;
    }

    public static function resizeImage($path, $width, $height): void
    {
        $image = Image::make($path);

        // fit
        if ($width && $height) {
            $image->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            }, 'center');

            // aspect ratio
        } else {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $image->save($path);
    }

    public static function createThumb($imagePath, $imageName, $thumbPath, $width, $height)
    {
        $image = Image::make($imagePath . '/' . $imageName);;

        // fit
        if ($width && $height) {
            $image->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            }, 'center');

            // aspect ratio
        } else {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $image->save($thumbPath . '/' . $imageName);
    }

    private static function cutAndTrim($string, $length): string
    {
        if (mb_strlen($string) < $length) {
            $string = mb_substr($string, 0, $length);
        }

        $string = trim($string);

        return $string;
    }

    private static function transliterateIntoLatin($string): string
    {
        $search = [
            'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
            'ӣ', 'ӯ', 'ҳ', 'қ', 'ҷ', 'ғ', 'Ғ', 'Ӣ', 'Ӯ', 'Ҳ', 'Қ', 'Ҷ',
            ' ', '_'
        ];

        $replace = [
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shb', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'i', 'u', 'h', 'q', 'j', 'g', 'g', 'i', 'u', 'h', 'q', 'j',
            '-', '-'
        ];

        // manual transilation
        $transilation = str_replace($search, $replace, $string);

        // auto transilation
        $transilation = Str::ascii($transilation);

        return $transilation;
    }

    // ******************** ONLY DASHBOARD FUNCTIONS ********************
    /**
     * !!! To escape errors, all routes name prefix and routes second segments must be IDENTICAL !!!
     *
     * Used on generating routes
     * Shared with all dashboard views by AppServiceProvider
     */
    public static function getModelPrefixName(): string
    {
        return request()->segment(2);
    }

    public static function getRequestParams($defaultOrderBy, $defaultOrderType): array
    {
        $params = [
            'orderBy' => request()->orderBy ?: $defaultOrderBy,
            'orderType' => request()->orderType ?: $defaultOrderType,
            'currentPage' => LengthAwarePaginator::resolveCurrentPage(),
            'keyword' => request()->keyword,
        ];

        $params['reversedOrderType'] = self::reverseOrderType($params['orderType']);

        return $params;
    }

    private static function reverseOrderType($orderType): string
    {
        return $orderType == 'asc' ? 'desc' : 'asc';
    }
}
