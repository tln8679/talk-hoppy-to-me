<?php
    include('includes/header.html');
?>
    <section>
        <?php
            $name = $_REQUEST['fname'] . ' ' . $_REQUEST['lname'];
            echo "<div class=\"alert alert-success\" role=\"alert\">
                <p>Thanks for registering <strong>$name</strong></p>
            </div>";
        ?>
    </section>
<?php
    include('includes/footer.html');
?>