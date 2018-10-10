<?php
    include('includes/header.html');
?>
    <section>
        <?php
            $name = $_REQUEST['fname'] . ' ' . $_REQUEST['lname'];
            echo "Thanks for registering <strong>$name</strong>";
        ?>
    </section>
<?php
    include('includes/footer.html');
?>