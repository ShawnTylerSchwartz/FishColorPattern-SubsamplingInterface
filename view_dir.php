<?php include 'pageheader_template.php'; ?>

<?php

	//path to directory to scan
	$directory = $_GET['dir'];
 
	//get all image files with a .jpg extension.
	$images = glob($directory . "*.jpg");
 
	// print each file name into list with link to image
	foreach($images as $image) {
		//echo "<ul>";
		//	echo "<li><a href='subsample_image.php?image=" . $image . "'>" . $image . "</a></li>";
		//echo "</ul>";
		echo "<div class='list-group'>";
 			echo "<button type='button' class='list-group-item list-group-item-action'>";
 				echo "<a href='subsample_image.php?image=" . $image . "'>" . $image . "</a></li>";
 			echo "</button>";
 		echo "</div>";
	}

?>

<?php include 'pagefooter_template.php'; ?>