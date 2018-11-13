<?php include 'pageheader_template.php'; ?>

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
 		//echo "<ul>";
 			//echo "<li><a href='view_dir.php?dir=" . $dir . "'>" . $dir . "</a></li>";
 		//echo "</ul>";
 		echo "<div class='list-group'>";
 			echo "<button type='button' class='list-group-item list-group-item-action'>";
 				echo "<a href='view_dir.php?dir=" . $dir . "'>" . $dir . "</a></li>";
 			echo "</button>";
 		echo "</div>";

 	}
?>

<?php include 'pagefooter_template.php'; ?>