<?php
	//include file from upload_image.php 
	//creates a thumbnail from an uploaded image
	//before executing this file, create a folder in the site images folder named /user_thumbs
	define('MAX_SIZE', 120);
	define('SUFFIX','_thb');
	global $image_info;  //expand scope because this is an includes file
	$width = $image_info[0];
	$height = $image_info[1];
	$type = $image_info['mime']; 
	$basename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME); //return just the filename without the path or extension
	if ($width <= MAX_SIZE && $height <= MAX_SIZE) {
         $ratio = 1;
        } elseif ($width > $height) {
            $ratio = MAX_SIZE/$width;
        } else {
            $ratio = MAX_SIZE/$height;
        }
    $thumbwidth = round($width * $ratio);
    $thumbheight = round($height * $ratio);
	$shortType = substr($type, 6); //MIME type image/
	$path = "../../uploads/$folder/".$_FILES['image']['name'];
	if ($shortType=='gif') {
        $resource = imagecreatefromgif($path);
    }elseif ($shortType=='png') {
        $resource = imagecreatefrompng($path); 
	} else {
		$resource = imagecreatefromjpeg($path);
		}
	$thumb = imagecreatetruecolor($thumbwidth, $thumbheight)  or die('Cannot Initialize new GD image stream');
    imagecopyresampled($thumb, $resource, 0, 0, 0, 0, $thumbwidth, $thumbheight, $width, $height);
	$prefix = $_SESSION['folder'] . '_';
    $newname = $prefix . $basename . SUFFIX;
	
	//create a folder in the site images folder named /user_thumbs need to be created
    $destination = 'images/user_thumbs/'; 
        if ($shortType == 'jpeg') {
            $newname .= '.jpg';
            $success = imagejpeg($thumb, $destination . $newname);
        } elseif ($shortType == 'png') {
            $newname .= '.png';
            $success = imagepng($thumb, $destination . $newname);
		}elseif ($shortType == 'gif') {
            $newname .= '.gif';
            $success = imagegif($thumb, $destination . $newname);
		}
	if ($success) {
            echo "And the thumbnail image, $newname, was created successfully.<br>";
			echo "<img src = '".$destination.$newname."' alt = 'New Thumbnail Image'>";
        } else {
            $message = "Couldn't create a thumbnail for $basename";
        }
        imagedestroy($resource);
        imagedestroy($thumb);
?>