<?php
/**
 * Image Resizer
 */

namespace App\Classes;

use \Image;
use \Storage;

class ImageResizer
{
	const RESIZE = 'resize';
	const FIT = 'fit';

	/**
	 * Resize an image to exact dimensions
	 *
	 * - This method WILL NOT maintain aspect ratio
	 * - This method WILL scale an image up, if needed
	 */
	public static function resize($key, $url, $width = 0, $height = 0, $format = 'jpg')
	{
		return self::generate_image(self::RESIZE, $key, $url, $width, $height, $format);
	}

	/**
	 * Fit an image within specified dimensions
	 *
	 * - This method WILL maintain aspect ratio
	 */
	public static function fit($key, $url, $width = 0, $height = 0, $format = 'jpg')
	{
		return self::generate_image(self::FIT, $key, $url, $width, $height, $format);
	}


	/**
	 * The main function to resize all images
	 *
	 * @param string $resize_mode 'resize' or 'fit'
	 * @param string $key A "collection" or "group" for this image. Basically resolves to a folder
	 * @param string $url Url to the source image
	 * @param int $width The resulting width (pass 0 if no preference of width)
	 * @param int $height The resulting height (pass 0 if no preference of height)
	 * @param string $format The image file format to return
	 *
	 * @return mixed false|string Returns the local path to the resized image, or false
	 */
	private static function generate_image($resize_mode, $key, $url, $width, $height, $format)
	{
		// make sure requested format is supported
		$format = self::get_validated_format($format);

		// all arguments are required
		if( empty($key) || empty($url) || (empty($width) && empty($height)) )
		{
			return false;
		}

		// generate filename and path
		$full_path = self::get_full_path($resize_mode, $key, $url, $width, $height, $format);

		// first check to see if we already have a resized version
		if(Storage::disk('public')->exists($full_path))
		{
			\Log::debug('Resized image returned from cache (image was NOT resized!)');
			return $full_path;
		}

		// resized image does not exists, let's create one
		//TODO - catch NotReadableException, return a 'missing photo' image?
		$img = Image::make($url);

		switch($resize_mode)
		{
			case self::FIT:
				$img->resize($width <= 0 ? null : $width, $height <= 0 ? null : $height, function($constraint) {
					$constraint->aspectRatio();
					$constraint->upsize();
				})->encode($format);
				break;

			case self::RESIZE:
			default:
				$img->resize($width, $height)->encode($format);
				break;
		}

		// save resized image
		Storage::disk('public')->put($full_path, (string)$img);

		return $full_path;
	}


	private static function get_full_path($resize_mode, $key, $url, $width, $height, $format)
	{
		$filename = md5($resize_mode.$key.$url.$width.$height.$format) . '.' . trim($format, '.');
		$path = trim(config('app.folders.base_image_cache'), '/') . '/' . trim($key, '/') . "/{$width}x{$height}/";

		return $path . $filename;
	}

	/**
	 * Make sure the file format is correct/supported.
	 * Defaults to 'jpg' if invalid format is passed in.
	 *
	 * @param string $value
	 * @return string A valid file format that is supported
	 */
	private static function get_validated_format($value)
	{
		$valid_formats = ['jpg', 'png', 'gif'];

		if(in_array($value, $valid_formats))
		{
			return $value;
		}

		return 'jpg';
	}
}