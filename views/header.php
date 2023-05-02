<?php
if (empty($_SESSION['active'])) {
	header('location: ../');
}
?>

<header>
    <?php include "nav.php" ?>
</header>
