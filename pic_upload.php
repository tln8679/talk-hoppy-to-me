<?php
$page_title = 'New pic!';
// Include header html here
include ('includes/header.php');
require_once '../../mysqli_connect.php';
require_once './beans/user.php';
ini_set('display_errors', 'On');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_SESSION['email'])) {
    $u_id = $_SESSION['usersID'];
    $email = $_SESSION['email'];
    // Check if the form has been submitted:
    if (isset($_POST['submit_picture'])) {
        // Check for an uploaded file:
        if (isset($_FILES['image'])) {
            $folder = "../../profile_pictures";
            $files = scandir($folder); // Read all the images into an array.
            // If user is changing their profile picture, delete their current pic first
            // We expect less than 1K users so order N for this doesn't matter unless it needs to eventually scale
            foreach ($files as $image) {
                if (substr($image, 0, 1) != '.') { // Ignore anything starting with a period.
                    $image_name = urlencode($image);
                    // if user id matches the users then unlink it
                    $pos = strpos($image_name, strval($u_id));
                    if ($pos !== false) {
                        $full_path = $folder . "/$image_name";
                        unlink($full_path);
                    }
                }
            }
            // Validate the type. Should be JPEG or PNG.
            $allowed = array('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'imageheade/gif', 'image/GIF');
            $name = $_FILES['image']['name'];
            $type = $_FILES['image']['type'];
            if (in_array($_FILES['image']['type'], $allowed)) {
                $name = $_FILES['image']['name'];
                $type = $_FILES['image']['type'];
                // Move the file over.
                // Change file name to append user id so it is always unique
                // TODO: Figure the issue of user changing their picture
                $pieces = explode(".", $name);
                $ext = "." . $pieces[1];
                $pic_path = "$folder/$u_id$ext";
                $image_name = $u_id . $ext;
                // Save and alter user table
                if (move_uploaded_file($_FILES['image']['tmp_name'], "$pic_path")) {
                    // Alter the user table, column for picture file path
                    $user_dir = "imgs/user_thumbs/$u_id$ext";
                    //hardcoding the user images that is in the public_html
                    $sql = "UPDATE USERS SET AVATAR = '$user_dir' WHERE USERS_ID = ?";
                    $stmt = mysqli_prepare($dbc, $sql);
                    // Bind and execute
                    mysqli_stmt_bind_param($stmt, 's', $u_id);
                    mysqli_stmt_execute($stmt);
                    $count = mysqli_affected_rows($dbc);
                    if ($count == 1) {
                        include ('create_thumb.php');
                    } else {
                        // if no count, it was probably overwritten
                        echo '<h2>The file ' . $image_name . ' has been overwritten!</h2>';
                        include ('create_thumb.php');
                    }
                } else { // Invalid type.
                    echo '<h2 class="warning">Please upload a , GIF, JPEG or PNG image.</h2>';
                }
            } // Check for an error:
            if ($_FILES['image']['error'] > 0) {
                echo '<p class="warning">The file could not be uploaded because: <strong>';
                // Print a message based upon the error.
                switch ($_FILES['image']['error']) {
                    case 1:
                        echo 'The file exceeds the upload_max_filesize setting in php.ini.';
                    break;
                    case 2:
                        echo 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                    break;
                    case 3:
                        echo 'The file was only partially uploaded.';
                    break;
                    case 4:
                        echo 'No file was uploaded.';
                    break;
                    case 6:
                        echo 'No temporary folder was available.';
                    break;
                    case 7:
                        echo 'Unable to write to the disk.';
                    break;
                    case 8:
                        echo 'File upload stopped.';
                    break;
                    default:
                        echo 'A system error occurred.';
                    break;
                } // End of switch.
                echo '</strong></p>';
            }
        }
    }
} else {
    echo "<h2>Need to login</h2>";
}
?>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <div class="w3-container">
                <form enctype="multipart/form-data" method="POST" action="pic_upload.php">
                    <fieldset>
                        <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                            <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Pic upload</i>
                        </legend>
                        <div class="form-group w3-margin-bottom" style="text-align: center;">
                            <span class="btn btn-default btn-file">
                                <input type="file" style="width:250px; margin: auto;" type="text" name="image" id="image" required>
                            </span>
                            <hr>
                        </div>
                        <div class="form-group w3-margin-bottom" style="text-align: center;">
                            <input type="submit" name="submit_picture" value="Upload" class="btn btn-primary">
                        </div>
                    </fieldset>
                </form>
        </div>
    </div>
  </div>
</div>
  <!-- End Page Container -->
</div>
<?php
include ('includes/footer.php');
?>
