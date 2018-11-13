<?php
    // page for admin to add beer
    include('../includes/AdminHeader.php');
    require('../beans/beer.php');
    echo "<h1>Add a form to insert a new beer into the database</h1>";
    echo "<h3>Make a drop down options for brewery name. 
        If the brewer of the beer hasn't been added yet, that needs to be done first</h3>";
?>

<?php
    include('../includes/footer.php');
?>