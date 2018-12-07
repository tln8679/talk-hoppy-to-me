<?php
//include file from upload_image.php
//creates a thumbnail from an uploaded image
//before executing this file, create a folder in the site images folder named /user_thumbs
define('MAX_SIZE', 400); // The higher this value, the cripser the photo
define('SUFFIX', '_thb');
$path = "$folder/$image_name";
$size = getimagesize($path);
$width = $size[0];
$height = $size[1];
$type = $size['mime'];
$basename = $image_name; //return just the filename without the path or extension
if ($width <= MAX_SIZE && $height <= MAX_SIZE) {
    $ratio = 1;
} elseif ($width > $height) {
    $ratio = MAX_SIZE / $width;
} else {
    $ratio = MAX_SIZE / $height;
}
$thumbwidth = round($width * $ratio);
$thumbheight = round($height * $ratio);
$shortType = substr($type, 6); //MIME type image/
$path = "$folder/$image_name";
if ($shortType == 'gif') {
    $resource = imagecreatefromgif($path);
} elseif ($shortType == 'png') {
    $resource = imagecreatefrompng($path);
} else {
    $resource = imagecreatefromjpeg($path);
}
$thumb = imagecreatetruecolor($thumbwidth, $thumbheight) or die('Cannot Initialize new GD image stream');
imagecopyresampled($thumb, $resource, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
//create a folder in the site images folder named /user_thumbs need to be created
$destination = 'imgs/user_thumbs/';
if ($shortType == 'jpeg') {
    $success = imagejpeg($thumb, $destination . $basename);
} elseif ($shortType == 'png') {
    $success = imagepng($thumb, $destination . $basename);
} elseif ($shortType == 'gif') {
    $success = imagegif($thumb, $destination . $basename);
}
if ($success) {
    echo "<div class=\"alert alert-success\" role=\"alert\">
<p>And the thumbnail image, $basename, was created successfully</p>
 <img src = \"$destination$basename\" alt = \"New Thumbnail Image\"></div>";
} else {
    $message = "Couldn't create a thumbnail for $basename";
}
imagedestroy($resource);
imagedestroy($thumb);
?>
