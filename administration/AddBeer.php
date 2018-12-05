<?php
// page for admin to add brewer
// Adds brewer if it does not exist already
$page_title = 'Add beer!';
include ('../includes/AdminHeader.php');
require_once '../../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['beer'])) $name = trim($_POST['beer']);
    else $error_message[] = "You forgot the beer name";
    if (!empty($_POST['description'])) {
        $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
    } else {
        $error_message[] = "You forgot the description.";
    }
    if (!empty($_POST['style'])) {
        $style = filter_var(trim($_POST['style']), FILTER_SANITIZE_STRING);
    } else {
        $error_message[] = "You forgot the style.";
    }
    if (!empty($_POST['ibu'])) {
        $ibu = filter_var(trim($_POST['ibu']), FILTER_SANITIZE_STRING);
    } else {
        $error_message[] = "You forgot the IBU.";
    }
    if (!empty($_POST['abv'])) {
        $abv = filter_var(trim($_POST['abv']), FILTER_SANITIZE_STRING);
    } else {
        $error_message[] = "You forgot the ABV.";
    }
    //   Select always set
    $brewer_id = $_POST['brewers'];
    if (empty($error_message)) {
        $q = "SELECT * FROM BEER WHERE BEER_NAME = ?";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        $stmt->store_result();
        $count = $stmt->num_rows;
        if ($count > 0) {
            echo "
            <div class=\"alert alert-info\" role=\"alert\">
                <p><strong>$name</strong>This brewery is already created!</p>
            </div>";
            include '../includes/footer.php';
            exit;
        } else {
            // Prepare and bind
            $q = "INSERT INTO BEER(BEER_NAME, BEER_DESCRIPTION, BEER_STYLE, BEER_IBU, BEER_ABV, BREWER_ID) VALUES (?,?,?,?,?,?)";
            $stmt = mysqli_prepare($dbc, $q);
            // 'sss' declares the types that we are inserting
            mysqli_stmt_bind_param($stmt, 'ssssss', $name, $description, $style, $ibu, $abv, $brewer_id);
            //  Set parameters and execute
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "
            <div class=\"alert alert-success\" role=\"alert\">
                <p>Thanks for adding <strong>$name</strong></p>
            </div>";
                include '../includes/footer.php';
                exit;
            } else {
                echo "<div class=\"alert alert-info\" role=\"alert\">
                    <p>We're sorry, we were not able to add {Name: $name, Description: $description, Style: $style, IBU: $ibu, ABV: $abv, BREWID: $brewer_id at this time.</p>
                </div>";
                include '../includes/footer.php';
                exit;
            }
        }
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
            <p>Please check the following issues <strong><br>";
        foreach ($error_message as $missed) {
            echo '+ ' . $missed . "<br>";
        }
        echo "</strong></p></div>";
    }
}
?>
<div class="w3-row-padding">
    <div class="w3-container w3-card w3-white w3-margin-bottom">  
        <div class="w3-container">
            <form method="POST" action="AddBeer.php">
                <fieldset>
                    <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                        <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Add a beer</i>
                    </legend>  
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Beer Name</label>
                        <input name="beer" type="text" style="width:250px; margin: auto;" <?php if (isset($name)) echo " value=\"$name\""; ?> class="form-control" maxlength="55">
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Beer Style</label>
                        <input name="style" type="text" style="width:250px; margin: auto;" <?php if (isset($style)) echo " value=\"$style\""; ?> class="form-control" maxlength="50">
                    </div>

                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>IBU</label>
                        <input name="ibu" type="text" style="width:250px; margin: auto;" <?php if (isset($ibu)) echo " value=\"$ibu\""; ?> class="form-control" maxlength="22">
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>ABV</label>
                        <input name="abv" type="text" style="width:250px; margin: auto;" <?php if (isset($abv)) echo " value=\"$abv\""; ?> class="form-control" maxlength="22">
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Description</label>
                        <textarea rows="5" name="description" style="width:250px; margin: auto;" class="form-control" maxlength="10000" ><?php if (isset($description)) echo $description; ?></textarea>
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">
                        <label>Brewer</label><br>
                        <select name="brewers">
                        <?php
//   Query all the breweries and make a drop down menu with Brewer_id as the value.
$sql = "SELECT BREWER_ID, BREWER_NAME FROM BREWER ORDER BY BREWER_NAME";
$r = mysqli_query($dbc, $sql);
if (mysqli_num_rows($r) > 0) { // Beers found.
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo "<option value='" . $row['BREWER_ID'] . "'>" . $row['BREWER_NAME'] . "</option>";
    }
}
?>
                        </select>  
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;">           
                        <input type="submit" name="submit" value="Add" class="btn btn-primary">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<?php
include ('../includes/footer.php');
?>
