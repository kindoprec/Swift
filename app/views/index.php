<?php include('header.php'); ?>
	
    <div id="main-container">
        <h1>Yah! You're are now a Pirate</h1>
        <p>To get started please read the documentation at <a href="http://kindoprec.github.com/Swift">http://kindoprec.github.com/Swift</a>.</p>
    </div>
    <?php

    foreach( $eUser as $item ) {
    	echo $item->email.'<br>';
    }

    ?>

<?php include('footer.php'); ?>