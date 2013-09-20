<?php

namespace Acme\ImageBundle;
class Resize 
{
	public function img_resize($mode, $src, $dest, $width, $height, $quality=100)
	{
	  $dest = getcwd(). $dest;
	  $src = getcwd() . "\\" . $src;
	  
	  //make dir if it isnt exist
	  /*if (!file_exists('.\\images\\cache\\' . $_GET['preset-name'])) {
		mkdir('.\\images\\cache\\' . $_GET['preset-name']);
	  } */
	  

	  if (!file_exists($src)) return false;
	  
	  $size = getimagesize($src);
	  if ($size === false) return false;

	  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
	  $icfunc = "imagecreatefrom" . $format;
	  if (!function_exists($icfunc)) return false;

	  switch ($mode) {
		case 'IN':
		  $x_ratio = $width / $size[0];
		  $y_ratio = $height / $size[1];

		  $ratio       = min($x_ratio, $y_ratio);
		  $new_width   = floor($size[0] * $ratio);
		  $new_height  = floor($size[1] * $ratio);
		  $left_offset = 0;
		  $top_offset = 0;
		  $resize = false;
		  break;
		case 'OUT':
		  $x_ratio = $size[0] / $width;
		  $y_ratio = $size[1] / $height;

		  $ratio       = min($x_ratio, $y_ratio);
		  $new_width   = floor($width * $ratio);
		  $new_height  = floor($height * $ratio);

		  $left_offset = ($size[0] - $new_width) / 2;
		  $top_offset = ($size[1] - $new_height) / 2;
		  $resize = true;
		  break;
		case 'EXACT':
		  $left_offset = 0;
		  $top_offset = 0;
		  $new_width   = $width;
		  $new_height  = $height;
		  $resize = false;

	  }

	  $isrc = $icfunc($src);
	  $idest = imagecreatetruecolor($new_width, $new_height);
	  
	  imagecopyresampled($idest, $isrc, 0, 0, $left_offset, $top_offset, $new_width, $new_height, $size[0]-$left_offset*2, $size[1]-$top_offset*2);
	  
	  if ($resize) {
		$resized = imagecreatetruecolor($width, $height);
		imagecopyresampled($resized , $idest, 0, 0, 0, 0, $width, $height, $new_width, $new_height);
		imagejpeg($resized, $dest, $quality);
		imagedestroy($resized);
	  }
	  
	  else if(!(imagejpeg($idest, $dest, $quality))) return false;

	  imagedestroy($isrc);
	  imagedestroy($idest);
	  
	  return true;
	}
	function find_all_files($dir) 
	{ 
		$root = scandir($dir); 
		foreach($root as $value) 
		{ 
			if($value === '.' || $value === '..') {continue;} 
			if(is_file("$dir/$value")) {$result[]="$value";continue;} 
		} 
		return $result; 
	} 
}
?>