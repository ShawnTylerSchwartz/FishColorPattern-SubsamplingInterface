<?php
	include 'snippets/header.php';
	include 'snippets/main.php';
?>

<p class="lead">Click on a directory below to get started.</p>

<?php
	// define function getAllDirs
		// (return first level img directories)

	function getAllDirs($directory, $directory_seperator) {
		$dirs = array_map(function ($item) use ($directory_seperator) {
    		return $item . $directory_seperator;
		}, array_filter(glob($directory . '*'), 'is_dir'));

		foreach ($dirs as $dir) {
    		$dirs = array_merge($dirs, getAllDirs($dir, $directory_seperator));
		}
	
		return $dirs;
	}

	// path to directory to scan 
	$directory = "fish_input/";
 	$directory_seperator = "/";

	$alldirs = getAllDirs($directory, $directory_seperator);
 	
 	// print each file name into list with link to next-level of image directory
 	foreach($alldirs as $dir) {

 		//path to directory to scan
		$directory = $dir;
 
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
			if (in_array($image, $tmpstorage)) {
				$numCompleted++;
			} else {
				break;
			}

			$totalNumImgs = count($images);
			// printf($totalNumImgs);

			$percentCompleted = (($numCompleted+1) / $totalNumImgs) * 100;
			$numRemaining = $totalNumImgs - ($numCompleted);
			
			if ($numCompleted != 0) {
				$percentCompleted = (($numCompleted) / $totalNumImgs) * 100;
				$numRemaining = $totalNumImgs - ($numCompleted);
			} else {
				$percentCompleted = 0;
				$numRemaining = $totalNumImgs - ($numCompleted);
			}
		}

		// printf($numCompleted);
		// printf($numRemaining);
		// printf($percentCompleted);

		echo "<ul class='list-group'>";
  			echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
    			echo "<a href='view_dir.php?dir=" . $dir . "'>" . $dir . "</a>";
    			/*if($numRemaining == 0) {echo "<span class='badge badge-success badge-pill'><i class='fas fa-star'></i> $numRemaining</span>";} else { echo "<span class='badge badge-danger badge-pill'><i class='fas fa-star-half-alt'></i> $numRemaining</span>"; }
    			if($percentCompleted == 100) { echo "<span class='badge badge-success badge-pill'>$percentCompleted%</span>"; } else { echo "<span class='badge badge-primary badge-pill'>$percentCompleted%</span>"; }*/
  			echo "</li>";
  			echo "<div style='margin-bottom: 10px;'></div>";
		echo "</ul>";


 	}
?>

<?php include 'snippets/footer.php'; ?>