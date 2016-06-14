<?php
class Ext_Base_Image {
	public static function exif($file) {
		$rotateImage = 0;
		$errorExif = false;

		if (function_exists('read_exif_data')) {
			$exif = @exif_read_data($file['file']);
			if($exif) {
				//We're only interested in the orientation
				$exif_orient = isset($exif['Orientation']) ? $exif['Orientation'] : 0;

				//We convert the exif rotation to degrees for further use
				if (6 == $exif_orient) {
					$rotateImage = 90;
					$imageOrientation = 1;
				} elseif (3 == $exif_orient) {
					$rotateImage = 180;
					$imageOrientation = 1;
				} elseif (8 == $exif_orient) {
					$rotateImage = 270;
					$imageOrientation = 1;
				}
			} else {
				$errorExif = true;
			}
		}

		if ($errorExif) {
			$content = file_get_contents($file['file']);
			$pos = strpos($content, 'apple-fi:AngleInfoRoll');
			if(false !== $pos) {
				$rotateImage = 360 - preg_replace('@.*?([0-9]+).*@', '$1', substr($content, $pos, 27));
			}
		}

		//if the image is rotated
		if ($rotateImage) {

			//WordPress 3.5+ have started using Imagick, if it is available since there is a noticeable difference in quality
			//Why spoil beautiful images by rotating them with GD, if the user has Imagick

			if (class_exists('Imagick')) {
				$imagick = new Imagick();
				$imagick->readImage($file['file']);
				$imagick->rotateImage(new ImagickPixel(), $rotateImage);
				$imagick->setImageOrientation($imageOrientation);
				$imagick->writeImage($file['file']);
				$imagick->clear();
				$imagick->destroy();
			} else {

				//if no Imagick, fallback to GD
				//GD needs negative degrees
				$rotateImage = -$rotateImage;

				switch ($file['type']) {
					case 'image/jpeg':
						$source = imagecreatefromjpeg($file['file']);
						$rotate = imagerotate($source, $rotateImage, 0);
						imagejpeg($rotate, $file['file']);
						break;
					case 'image/png':
						$source = imagecreatefrompng($file['file']);
						$rotate = imagerotate($source, $rotateImage, 0);
						imagepng($rotate, $file['file']);
						break;
					case 'image/gif':
						$source = imagecreatefromgif($file['file']);
						$rotate = imagerotate($source, $rotateImage, 0);
						imagegif($rotate, $file['file']);
						break;
					default:
						break;
				}
			}
		}
		// The image orientation is fixed, pass it back for further processing
		return $file;
	}
}