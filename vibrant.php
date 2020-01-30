<?php

// Dependency: This function relies on @brandonheyer's (https://gist.github.com/brandonheyer) rgbToHsl() and hslToRgb()
// functions (https://gist.github.com/brandonheyer/5254516). It helped me to reduce my extra work and that's why I am
// thankful to him.
//
// To make this function work, his PHP needs to be included first which you can find in the link mentioned above.
// So, here we go.
//
//
// include 'rgbToHSL.php';

function vibrant($image_source, $square_block = 8, $target_lightness = 0.5, $min_lightness = 0.31, $max_lightness = 0.69, $target_saturation = 1, $min_saturation = 0, $max_saturation = 1, $exception = true)
{
	$resized = imagecreatetruecolor($square_block, $square_block);
	
	$extension = strtolower(pathinfo($image_source, PATHINFO_EXTENSION));
	if(($extension == "jpg") || ($extension == "jpeg"))
	{
		$image = imagecreatefromjpeg($image_source);
	}
	elseif($extension == "png")
	{
		$image = imagecreatefrompng($image_source);
		imagealphablending($resized, false );
		imagesavealpha($resized, true );
	}
	
	imagecopyresampled($resized, $image, 0, 0, 0, 0, $square_block, $square_block, imagesx($image), imagesy($image));
	
	$allcolors = [];
	
	for($y = 1; $y <= $square_block; $y++)
	{
		for($x = 1; $x <= $square_block; $x++)
		{
			$temp_color = imagecolorsforindex($resized, imagecolorat($resized, $x, $y));
			$allcolors[] = $temp_color["red"].",".$temp_color["green"].",".$temp_color["blue"];
		}
	}
	
	
	// Let's destroy the images to free up the memory. We don't need the images now as we have already got the color array
	imagedestroy($image);
	imagedestroy($resized);
	
	$uniquecolors = array_unique($allcolors);
	
	$nearest_light = 1;
	$nearest_saturation = 1;
	$key_id = false;
	
	foreach($uniquecolors as $unique_key => $uniqueone)
	{
		$rgbfromunique = explode(",", $uniqueone);
		$hsl_uniquecolors = rgbToHsl($rgbfromunique[0], $rgbfromunique[1], $rgbfromunique[2]);
		
		if((abs($target_lightness - $hsl_uniquecolors[2]) < $nearest_light) && ($hsl_uniquecolors[2] >= $min_lightness) && ($hsl_uniquecolors[2] <= $max_lightness) && (abs($target_saturation - $hsl_uniquecolors[1]) < $nearest_saturation) && ($hsl_uniquecolors[1] >= $min_saturation) && ($hsl_uniquecolors[1] <= $max_saturation))
		{
			$nearest_light = abs(0.5 - $hsl_uniquecolors[2]);
			$nearest_saturation = abs($target_saturation - $hsl_uniquecolors[1]);
			$key_id = $unique_key;
		}
	}
	
	// Backup:  If the image really fails to return any expected colors, then remove the min and max criterias and pick the nearest-to-target colour
	
	if($exception)
	{
		if($key_id === false)
		{
			foreach($uniquecolors as $unique_key => $uniqueone)
			{
				$rgbfromunique = explode(",", $uniqueone);
				$hsl_uniquecolors = rgbToHsl($rgbfromunique[0], $rgbfromunique[1], $rgbfromunique[2]);

				if((abs($target_lightness - $hsl_uniquecolors[2]) < $nearest_light) && (abs($target_saturation - $hsl_uniquecolors[1]) < $nearest_saturation))
				{
					$nearest_light = abs(0.5 - $hsl_uniquecolors[2]);
					$nearest_saturation = abs($target_saturation - $hsl_uniquecolors[1]);
					$key_id = $unique_key;
				}
			}
		}
	}
	
	return explode(",", $uniquecolors[$key_id]);
}
?>
