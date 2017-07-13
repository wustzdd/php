<?php
/**
 * Thumb one image
 *
 * @author 51tjc.net
 * @example
 * ?src=S/sp0058_1.png
 * ?src=S/sp0058_1.png&s=200x140
 * ?src=S/sp0058_1.png&w=200
 * ?src=S/sp0058_1.png&w=200&h=140
 * ?src=S/sp0058_1.png&w=200&h=140&format=png
 */
define('RES_DIR', __DIR__.'/');

// Source image
if (!isset($_GET['src'])) {
    // TODO, display one default image
    exit;
}
$src = $_GET['src'];

// Check whether or not exists
if (!file_exists(RES_DIR . $src)) {
    //Http::headerStatus(404);
    die;
}

// Init the source image
$image = new Imagick(RES_DIR . $src);

// Target type, allow jpeg/png
$defaultFormat = strtolower($image->getImageFormat());
$targetFormat = (isset($_GET['format']) && in_array(strtolower($_GET['format']), array('jpg', 'jpeg', 'png')))
                    ? strtolower($_GET['format'])
                    : $defaultFormat;

// Current height & width
$srcGeometry = $image->getImageGeometry();

// Target width & height
if (isset($_GET['s'])) {
    $arr = explode('x', $_GET['s']);
    if (count($arr) < 2) {
        die;
    }
    $targetWidth = intval($arr[0]);

    $targetHeight = intval($arr[1]);
    if ($targetHeight == 0) {
       $targetHeight = intval($targetWidth * $srcGeometry['height'] / $srcGeometry['width']); 
    }
}
else {
    if (isset($_GET['w']) && isset($_GET['h'])) {
        $targetWidth = (int)$_GET['w'];
        $targetHeight = (int)$_GET['h'];
    } elseif (isset($_GET['w']) && !isset($_GET['h'])) {
        $targetWidth = (int)$_GET['w'];
        $targetHeight = intval((int)$_GET['w'] * $srcGeometry['height'] / $srcGeometry['width']);
    } elseif (!isset($_GET['w']) && isset($_GET['h'])) {
        $targetWidth = intval((int)$_GET['h'] * $srcGeometry['width'] / $srcGeometry['height']);
        $targetHeight = (int)$_GET['h'];
    } else {
        $targetWidth = $srcGeometry['width'];
        $targetHeight = $srcGeometry['height'];
    }
}
if($targetWidth> $srcGeometry['width'] && $targetHeight > $srcGeometry['height']) {
    $targetWidth = $srcGeometry['width'];
    $targetHeight = $srcGeometry['height'];
}

// Check whether need fill height space
//$targetHeightTemp = $srcGeometry['height'] * $targetWidth / $srcGeometry['width']; do not fill white anyway.
$targetHeightTemp = $targetHeight;

if ($targetHeight != $srcGeometry['height'] || $targetWidth != $srcGeometry['width']) {
    $image->cropThumbnailImage($targetWidth, $targetHeightTemp);
    400 == $targetHeight && 400 == $targetWidth ? $image->setImageCompressionQuality(55) : $image->setImageCompressionQuality(90);
    $image->sharpenImage(1, 0.6);
}

// Set the image format
$image->setImageFormat($targetFormat);

// Set the resolution
$image->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
$image->setImageResolution(72, 72);

// Set the display mode
if ($targetWidth > 300) {
    $image->setInterlaceScheme(Imagick::INTERLACE_PLANE);
}

// Strip the exif
$image->stripImage();

// Set header to image
header('Content-type: image/' . $targetFormat);

// Browser will cache one hour
//Http::cache(3600);

// When need white space, first paint one canvas, then merge the image with it
if ($targetHeightTemp != $targetHeight) {
    $convas = new Imagick();
    $convas->newImage($targetWidth, $targetHeight, new ImagickPixel("#FFF"));
    $convas->setImageFormat($targetFormat);
    $convas->compositeImage($image, Imagick::COMPOSITE_OVER, 0, ($targetHeight - $targetHeightTemp) / 2);
    $convas->setInterlaceScheme(Imagick::INTERLACE_PLANE);

    echo $convas;
}
// Do not need convas
else {
    echo $image;
}
