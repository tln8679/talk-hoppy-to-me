<?php
/*
 *  This page displays all beers and will have a search function. When the user chooses to add one to a list
 *  this same page loads with a form to add a comment and confirm the addition. User taken to
 *  log/love/or later.php to see their full list.
*/
$page_title = 'Make a suggestion!';
// Session is set in the header
include ('includes/header.php');
include ("beans/suggestion.php");
require_once '../../mysqli_connect.php';

if (empty($_SESSION['email'])) {
    // User hasn't logged in and clicked "My profile", so send him to log in page
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $url = rtrim($url, '/\\');
    $page = 'login.php';
    $url.= '/' . $page;
    header("Location: $url");
    exit();
}
if (isset($_POST['submit'])) {
    if (isset($_SESSION['usersID'])) {
        $curr_user = $_SESSION['usersID'];
    }
    // Create scalar variables for the form data:
    if (!empty($_POST['suggestion'])) $suggestion = filter_var($_POST['suggestion'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    else $missing[] = "name";
    $nature = $_POST['nature'];
    if (isset($missing)) { //There is at least one element in the $missing array
        echo 'You forgot the following form item(s):<br>';
        //output the contents of the array
        foreach ($missing as $missed) {
            echo '-' . $missed . "<br>";
        }
    } else {
        // This is where we insert the suggestion into the database
        // Admins will then be able to view the Suggestion
        $sql = "INSERT INTO `SUGGESTION` (`USER_ID`, `NATURE`, `COMMENT`) VALUES (?,?,?)";
        $stmt = mysqli_prepare($dbc, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $curr_user, $nature, $suggestion);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_affected_rows($stmt)) { //It worked
            //Form was filled out completely and submitted. Print the submitted information:
            echo "<p>Thank you, for the following comments:<br>";
            echo "<pre>\"$suggestion\"</pre>"; //HTML pre is preformatted text. We are assuming the comment is non-malicious
            include ('includes/footer.php');
            exit;
        } else {
            echo "<div class=\"alert alert-info\" role=\"alert\">
                    <p>We're sorry, there was an error trying to suggest: $suggestion</p>
                    </div>";
        }
    }
}
?>

<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">
        <div class="w3-container">            
            <form method="POST" action="suggest.php">
                <fieldset>
                    <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                        <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Make a suggestion!</i>
                    </legend>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                      <label>Nature of your suggestion:</label><br>
                              <select name="nature">
                        <?php
if (isset($_POST['submit'])) {
    echo "<option selected value=\"$nature\">$nature</option>\n";
}
?>
                            <option value="add">Add a beer</option>
                            <option value="add">Edit a beer</option>
                            <option value="add">Report a user</option>
                            <option value="add">Other</option>
                        </select>
                    </div>

                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Suggestion:</label>
                        <textarea rows="5" name="suggestion" style="width:250px; margin: auto;" class="form-control" maxlength="10000" ><?php if (isset($suggestion)) echo $suggestion; ?></textarea>
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">           
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include ('includes/footer.php');
?>