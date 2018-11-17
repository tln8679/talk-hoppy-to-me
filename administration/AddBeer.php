<?php
    // page for admin to add brewer
    // Adds brewer if it does not exist already
    include('../includes/AdminHeader.php');
    require_once '../../../mysqli_connect.php'; //$dbc is the connection string set upon successful connection

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!empty($_POST['beer']))
  			$name = filter_var(trim($_POST['beer']), FILTER_SANITIZE_STRING);
  		else
  			$error_message[]= "You forgot the beer name";

      if (!empty($_POST['description'])){
                $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
            }
  		else{
              $error_message[] = "You forgot the description.";
          }
      if (!empty($_POST['style'])){
                  $style = filter_var(trim($_POST['style']), FILTER_SANITIZE_STRING);
              }
    	else{
                $error_message[] = "You forgot the style.";
            }
      if (!empty($_POST['ibu'])){
                    $ibu = filter_var(trim($_POST['ibu']), FILTER_SANITIZE_STRING);
                }
      else{
                  $error_message[] = "You forgot the IBU.";
              }
      if (!empty($_POST['abv'])){
                      $abv = filter_var(trim($_POST['abv']), FILTER_SANITIZE_STRING);
                  }
      else{
                    $error_message[] = "You forgot the ABV.";
                }
    //   Select always set

    if (empty($error_message)){
      // $newBrewer = new Brewer(0, $name,$city,$state);
      $q = "SELECT * FROM BEER WHERE BEER_NAME = ?";
      $stmt = mysqli_prepare($dbc,$q);
      mysqli_stmt_bind_param($stmt,'s',$name);
      mysqli_stmt_execute($stmt);
      $stmt->store_result();
      $count = $stmt->num_rows;

      if ($count>0){
        echo "<div class=\"alert alert-info\" role=\"alert\">
          <p><strong>$name</strong>This brewery is already created!</p>

          </div>";
        include 'includes/footer.php';
        exit;
      }
      else{
        // Prepare and bind
        // $q = "INSERT INTO BREWER(BREWER_NAME, BREWER_CITY, BREWER_STATE) VALUES (?,?,?)";
        $q = "INSERT INTO BEER(BEER_ID, BEER_NAME, BEER_DESCRIPTION, BEER_STYLE, BEER_IBU, BEER_ABV, BREWER_ID) VALUES (?,?,?,?,?,?,?)";
        $stmt = mysqli_prepare($dbc,$q);
        // 'sss' declares the types that we are inserting
        mysqli_stmt_bind_param($stmt,'sssssss',$name, $name, $description, $style, $ibu, $abv);
        //  Set parameters and execute
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt)) { //It worked

          echo "<div class=\"alert alert-success\" role=\"alert\">
          <p>Thanks for adding <strong>$name</strong></p>
          </div>";
        }
        else
        echo "<div class=\"alert alert-info\" role=\"alert\">
          <p>We're sorry, we were not able to add the BEER_DESCRIPTION at this time.</p>
          </div>";
        include 'includes/footer.php';
        exit;
    }
   }
   else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">
        <p>Please check the following issues <strong><br>";
        foreach($error_message as $missed){
            echo '+ '.$missed."<br>";
        }
        echo "</strong></p></div>";
   }
 }
?>


    <div class="col-md-4 col-md-offset-4 w3-margin-bottom text-center">
        <form class="justify-content-center" method="POST" action="AddBrewer.php">
            <fieldset>
                <legend>
                    <h2>Add A Beer</h2>
                </legend>
                <div class="input-group w3-margin-bottom cntr-form">
                <div class="form-group">
                        <label>Beer Name</label>
                        <input name="beer" type="text" <?php if(isset($name)) echo " value=\"$name\"";?> class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input name="description" type="text" <?php if(isset($description)) echo " value=\"$description\"";?> class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>Beer Style</label>
                        <input name="style" type="text" <?php if(isset($style)) echo " value=\"$style\"";?> class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>IBU</label>
                        <input name="ibu" type="text" <?php if(isset($ibu)) echo " value=\"$ibu\"";?> class="form-control" >
                    </div>

                    <div class="form-group">
                        <label>ABV</label>
                        <input name="abv" type="text" <?php if(isset($abv)) echo " value=\"$abv\"";?> class="form-control" >
                    </div>
                    <!-- there is currently a bug where things are getting clipped off the screen
                    once they go below ABV (this is non-specfic to ABV, they just clip at a certain point) -->

                    <!-- currently there are two ways of doing the dropdown and i'm deciding on which one to use.
                    Neither work right now. -->
                    <!-- <div class="form-group">
                      <label>Brewer</label>
                      <select name="brewers">
                      <?php
                      $brewer_sql=mysql_query("SELECT BREWER_ID, BREWER_NAME FROM BREWER");
                      if(mysql_num_rows($brewer_sql)){
                      $select= '<select name="select">';
                      while($rs=mysql_fetch_array($brewer_sql)){
                          $select.='<option value="'.$rs['BREWER_ID'].'">'.$rs['BREWER_NAME'].'</option>';                        }
                      }
                      $select.='</select>';
                      echo $select;
                      ?>
                    </div> -->

                    <!-- <div class="form-group">
                      <label>Brewer</label>
                      <select name="brewers">
                      <?php
                      $brewer_query="SELECT BREWER_ID, BREWER_NAME FROM BREWER";
                      $brewer_result=mysql_query($query);
                      ?>
                      <?php
                      while ($row=mysql_fetch_array($brewer_result)){
                        echo "<option value='".$row['BREWER_ID']."'>'".$row['BREWER_NAME']."'</option>";
                      }
                      ?>
                      </select>

                    </div> -->

        <p>
            <span class="input-group-btn">
                <input type="submit" name="submit" value="Add Beer" class="btn btn-primary">
            </span>
        </p>
</fieldset>
</form>
</div>
<?php
    include('../includes/footer.php');
?>
