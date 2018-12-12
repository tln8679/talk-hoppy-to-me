<?php
// page for admin to add brewer
// Adds brewer if it does not exist already
$page_title = 'Add brewer!';
include ('../includes/AdminHeader.php');
require ('../beans/brewery.php');
require_once '../../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['brewer'])) $name = trim($_POST['brewer']);
    else $error_message[] = "You forgot the brewer name";
    if (!empty($_POST['city'])) {
        $city = trim($_POST['city']);
    } else {
        $error_message[] = "You forgot the city name.";
    }
    //   Select always set
    $state = $_POST['state'];
    if (empty($error_message)) {
        $newBrewer = new Brewer(0, $name, $city, $state);
        $q = "SELECT * FROM BREWER WHERE BREWER_NAME = ?";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 's', $name);
        mysqli_stmt_execute($stmt);
        $stmt->store_result();
        $count = $stmt->num_rows;
        if ($count > 0) {
            echo "<div class=\"alert alert-info\" role=\"alert\">
          <p><strong>$name</strong>This brewery is already created!</p>

          </div>";
            include 'includes/footer.php';
            exit;
        } else {
            // Prepare and bind
            $q = "INSERT INTO BREWER(BREWER_NAME, BREWER_CITY, BREWER_STATE) VALUES (?,?,?)";
            $stmt = mysqli_prepare($dbc, $q);
            // 'sss' declares the types that we are inserting
            mysqli_stmt_bind_param($stmt, 'sss', $name, $city, $state);
            //  Set parameters and execute
            $name = $newBrewer->getName();
            $city = $newBrewer->getCity();
            $state = $newBrewer->getState();
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt)) { //It worked
                echo "<div class=\"alert alert-success\" role=\"alert\">
          <p>Thanks for adding <strong>$name</strong></p>
          </div>";
            } else echo "<div class=\"alert alert-info\" role=\"alert\">
          <p>We're sorry, we were not able to add the brewer at this time.</p>
          </div>";
            include 'includes/footer.php';
            exit;
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
            <form method="POST" action="AddBrewer.php">
                <fieldset>
                    <legend class="w3-text-grey w3-padding-16" style="text-align: center;">
                        <i class="fa fa-suitcase fa-fw w3-xxlarge w3-text-indigo">Add a brewer</i>
                    </legend>   
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>Brewer Name</label>
                        <input name="brewer" type="text" style="width:250px; margin: auto;" <?php if (isset($name)) echo " value=\"$name\""; ?> class="form-control">
                    </div>
                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                        <label>City</label>
                        <input name="city" type="text" style="width:250px; margin: auto;" <?php if (isset($city)) echo " value=\"$city\""; ?> class="form-control" >
                    </div>

                    <div class="form-group w3-margin-bottom" style="text-align: center;"> 
                    <label>State</label>
                        <br>
                        <select id="state" name="state">
                            <option value="AL">AL</option>
                            <option value="AK">AK</option>
                            <option value="AR">AR</option>
                            <option value="AZ">AZ</option>
                            <option value="CA">CA</option>
                            <option value="CO">CO</option>
                            <option value="CT">CT</option>
                            <option value="DC">DC</option>
                            <option value="DE">DE</option>
                            <option value="FL">FL</option>
                            <option value="GA">GA</option>
                            <option value="HI">HI</option>
                            <option value="IA">IA</option>
                            <option value="ID">ID</option>
                            <option value="IL">IL</option>
                            <option value="IN">IN</option>
                            <option value="KS">KS</option>
                            <option value="KY">KY</option>
                            <option value="LA">LA</option>
                            <option value="MA">MA</option>
                            <option value="MD">MD</option>
                            <option value="ME">ME</option>
                            <option value="MI">MI</option>
                            <option value="MN">MN</option>
                            <option value="MO">MO</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="NC">NC</option>
                            <option value="NE">NE</option>
                            <option value="NH">NH</option>
                            <option value="NJ">NJ</option>
                            <option value="NM">NM</option>
                            <option value="NV">NV</option>
                            <option value="NY">NY</option>
                            <option value="ND">ND</option>
                            <option value="OH">OH</option>
                            <option value="OK">OK</option>
                            <option value="OR">OR</option>
                            <option value="PA">PA</option>
                            <option value="RI">RI</option>
                            <option value="SC">SC</option>
                            <option value="SD">SD</option>
                            <option value="TN">TN</option>
                            <option value="TX">TX</option>
                            <option value="UT">UT</option>
                            <option value="VT">VT</option>
                            <option value="VA">VA</option>
                            <option value="WA">WA</option>
                            <option value="WI">WI</option>
                            <option value="WV">WV</option>
                            <option value="WY">WY</option>
                            <option value="00">Imported</option>
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
