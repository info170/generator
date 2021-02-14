<?php

class ImageList
{
	public static function from_folder($path)
	{
		$images = scandir($path);
		$images = array_map(function($img) {
												$fileparts = explode('.',$img);
												if (end($fileparts)=='jpg') return $fileparts[0];
							  	  			}, $images);
		$images = array_values(array_filter($images));
		return $images;
	}
}

class Image
{
	public $image;
	private $img_name;

	function __construct($folder,$img_name)
	{
		$this->img_name = $img_name;
		$this->image = imagecreatefromjpeg($folder.$img_name.".jpg");
	}

	public function show()
	{
		return $this->image;
	}

	public function resize($img_size)
	{
	    $orig_width = imagesx($this->image);
	    $orig_height = imagesy($this->image);

		list($width,$height) = preg_split("/\s*\*\s*/",$img_size);

		if ($orig_width > $width or $orig_height > $height)
		{
			if ($orig_width > $orig_height) {
		    	$height = floor(($orig_height/$orig_width)*$width);
			} else if($orig_width < $orig_height) {
				$width = floor(($orig_width/$orig_height)*$height);
			}
		}

		$new_image = imagecreatetruecolor($width, $height);
    	imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

    	$this->image = $new_image;
	}

	public function save($path)
	{
		imagejpeg($this->image, $path.$this->img_name.".jpg");
	}
}
