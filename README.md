# vibrant-php
Pick the particular color from an image which contains your desired lightness and saturation. It is something like the awesome [palette class in Android](https://developer.android.com/reference/android/support/v7/graphics/Palette.html) or [vibrant.js](https://jariz.github.io/vibrant.js/) but instead it returns only one color based on your own demand.

# Dependency:
This PHP function is dependent on [@brendonheyer's](https://gist.github.com/brandonheyer) [rgbToHsl.php](https://gist.github.com/brandonheyer/5254516) and it must be included before vibrant.php. Thanks to him for it saved a lot of time.

# Usage

### Basic:

vibrant('path/to/image.jpg');

### All Parameters:

$image_source: _String_: _Required_ : Path to an image;  
$square_block: _Int_: _Optional (Default: 8)_ : An integer that determines the dimensions of the resampled square image. (E.g. 8 will generate 8x8 image).  
$target_lightness: _Float_: _Optional (Default: 0.5)_ : The goal for lightness of the target color  
$min_lightness: _Float_: _Optional (Default: 0.31)_ : Minimum lightness of the target color  
$max_lightness: _Float_: _Optional (Default: 0.69)_ : Maximum lightness of the target color  
$target_saturation: _Float_: _Optional (Default: 1)_ : The goal for saturation of the target color  
$min_saturation: _Float_: _Optional (Default: 0)_ : Minimum saturation of the target color  
$max_saturation: _Float_: _Optional (Default: 1)_ : Maximum saturation of the target color  
$exception: _boolean_ : _Optional (Default: true)_ : If in case, no colours match the exact criteria set by min and max lightness and saturation, then return a color that goes beyond those limitations and that is only influenced by the $target_lightness and $target_saturation.

### Advanced Use Example:

vibrant('path/to/image.jpg', 10, 0.4, 0.2, 0.6, 0.75, 0.5, 1, false);

### Return Value:

A successful vibrant() call will always return an array with RGB colors in it. An example return value is like:

array(  
  [0] => 200,  
  [1] => 180,  
  [2] => 150  
 )

# Special Thanks:
Special thanks to my colleagues at Bengal Web Solution (https://bengalwebsolution.com) for letting me have enough time for my own experiments, and my love - M for always supporting me and believing in me.

For any support, please visit http://itsamlan.com to contact me.
Thanks to everyone.
