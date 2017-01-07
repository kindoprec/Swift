<?php include('header.php'); ?>
	
    <div id="main-container">
        <h1>Yah! You're are now a Pirate</h1>
        <p>To get started please read the documentation at <a href="http://kindoprec.github.com/Swift">http://kindoprec.github.com/Swift</a>.</p>
    </div>

    <h1>Get all users:</h1>
    <?php

    foreach( $eUsers as $item ) {
    	echo $item['name'].'<br>';
    }

    ?>
    <hr>
    <h1>Get one user:</h1>
    <?php echo $user['name']; ?>

<?php include('footer.php'); ?>