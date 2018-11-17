<?php 
	include 'snippets/header.php';
	include 'snippets/main.php';
?>

<p class="lead">Click on a fish below to get subsample the fish's pattern.</p>

<?php
	//path to directory to scan
	$directory = $_GET['dir'];
 
	//get all image files with a .jpg extension.
	$images = glob($directory . "*.jpg");

	$block = 1024*1024; //1MB for file read in
	$tmpstorage = array();
	if ($fh = fopen("_outputData.html", "r")) { 
    	$left='';
    	while (!feof($fh)) { // read in file
       		$temp = fread($fh, $block);  
       		$fgetslines = explode("<hr />",$temp);
       		$fgetslines[0]=$left.$fgetslines[0];
       		if(!feof($fh) )$left = array_pop($lines);           
       		foreach ($fgetslines as $k => $line) {
		       	$completedComponents = explode(",", $line);
				array_push($tmpstorage, $completedComponents[0]);
	       	}
       	} 	
	}

	fclose($fh); // close file stream

	$numCompleted = 0;

	foreach ($images as $image) {
		$totalNumImgs = count($images);
		$numRemaining = $totalNumImgs - $numCompleted;
		$percentCompleted = (($numCompleted+1) / $totalNumImgs) * 100;

       	if (in_array($image, $tmpstorage)) {
       		echo "<div class='list-group'>";
 				echo "<a href='subsample_image.php?image=" . $image . "' class='list-group-item list-group-item-action list-group-item-success'>" . $image . "</a></li>";
 			echo "</div>";
 				$numCompleted++;
 		} else {
 			echo "<div class='list-group'>";
 				echo "<a href='subsample_image.php?image=" . $image . "' class='list-group-item list-group-item-action list-group-item-danger'>" . $image . "</a></li>";
 				echo "</div>";
 		}
	}

	echo "<div class='progress' style='height: 35px; margin-top: 25px;'>";
		echo "<div class='progress-bar' role='progressbar' style='font-size: 16px; font-weight: bolder; width: $percentCompleted%;'>$percentCompleted %</div>";
	echo "</div>";
	echo "<p class='lead'><em>Current progress...percentage of fishes scaled and cropped.</em></p><br /><br /><br />";
?>

<?php include 'snippets/footer.php'; ?>