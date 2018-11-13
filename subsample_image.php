<?php include 'subsampleheader_template.php'; ?>

		<?php
			$current_image = $_GET['image'];
		?>

		<p class="lead">You are currently subsampling <strong><?php echo $current_image; ?></strong></p>

		<!-- <img src="<?php echo $current_image; ?>" /> -->

		<br /><br />
		
		<canvas id="myCanvas" width="100px" height="100px"></canvas>
		<div class='clickable' id='clicker'>
			<span class='display'></span>
		</div>

		<!-- <input type="button" id="btnSave" value="Save PNG"/> -->

		<div id="img-out"></div>
		
				
		<script>
			var ClickOne_x = 0;
			var ClickOne_y = 0;

			var ClickTwo_x = 0;
			var ClickTwo_y = 0;

			var Click_TopCorner_x = 0;
			var Click_TopCorner_y = 0;
			var Click_BottomCorner_x = 0;
			var Click_BottomCorner_y = 0;

			var SquareLocation_x = 0;
			var SquareLocation_y = 0;


			var clickCounter = 0;

			// Tests
			console.log("xknot: " + ClickOne_x);
			console.log("yknot: " + ClickOne_y);

			clickable = document.getElementById('clicker');
			clickable.style.backgroundImage = "url('<?php echo $current_image; ?>')";
			clickable.style.backgroundSize = 'contain';
			clickable.style.backgroundRepeat = 'no-repeat';

		$('.clickable').bind('click', function (ev) {
			
			console.log("Clicks: " + clickCounter);

			if (clickCounter == 0) {
				var $div = $(ev.target);
				var $display = $div.find('.display');

				var offset = $div.offset();

				ClickOne_x = ev.clientX - offset.left;
				ClickOne_y = ev.clientY - offset.top;

				console.log("x1: " + ClickOne_x);
				console.log("y1: " + ClickOne_y);

				$display.text('Click1: ' + 'x: ' + ClickOne_x + ', y: ' + ClickOne_y);
			} else if (clickCounter == 1) {
				var $div = $(ev.target);
				var $display = $div.find('.display');

				var offset = $div.offset();

				ClickTwo_x = ev.clientX - offset.left;
				ClickTwo_y = ev.clientY - offset.top;

				console.log("x2: " + ClickTwo_x);
				console.log("y2: " + ClickTwo_y);

				$display.text('Click2: ' + 'x: ' + ClickTwo_x + ', y: ' + ClickTwo_y);
			} 
			// else if (clickCounter == 2) {
			// 	var $div = $(ev.target);
			// 	var $display = $div.find('.display');

			// 	var offset = $div.offset();

			// 	Click_TopCorner_x = ev.clientX - offset.left;
			// 	Click_TopCorner_y = ev.clientX - offset.top;

			// 	console.log("x3: " + Click_TopCorner_x);
			// 	console.log("y3: " + Click_TopCorner_y);

			// 	$display.text('Click3: ' + 'x: ' + Click_TopCorner_x + ', y: ' + Click_TopCorner_y);
			// } else if (clickCounter == 3) {
			// 	var $div = $(ev.target);
			// 	var $display = $div.find('.display');

			// 	var offset = $div.offset();

			// 	Click_BottomCorner_x = ev.clientX - offset.left;
			// 	Click_BottomCorner_y = ev.clientX - offset.top;

			// 	console.log("x3: " + Click_BottomCorner_x);
			// 	console.log("y3: " + Click_BottomCorner_y);

			// 	$display.text('Click4: ' + 'x: ' + Click_BottomCorner_x + ', y: ' + Click_BottomCorner_y);
			// } 
			else if (clickCounter == 2) {
				var $div = $(ev.target);
				var $display = $div.find('.display');

				var offset = $div.offset();

				SquareLocation_x = ev.clientX - offset.left;
				SquareLocation_y = ev.clientX - offset.top;

				console.log("xcrop: " + SquareLocation_x);
				console.log("ycrop: " + SquareLocation_y);

				$display.text('ClickCORNER: ' + 'x: ' + SquareLocation_x + ', y: ' + SquareLocation_y);
				var squareX = SquareLocation_x;
				var squareY = SquareLocation_y;
				console.log("squareX: " + squareX);
				console.log("squareY: " + squareY);
			} else {
				console.log("All clicks have been completed.");
			}
			
			clickCounter++;
			if ((clickCounter > 1) && (clickCounter < 3)) {
				// calculate distance between the two clicked points
				var diffs_x = (ClickOne_x - ClickTwo_x);
				var diffs_y = (ClickOne_y - ClickTwo_y);
				var standardLength = Math.sqrt((Math.pow(diffs_y,2))+(Math.pow(diffs_x,2)));
				console.log("Dist: " + standardLength);

				// calculate new scale factor
				var preImgWidth = document.getElementById('clicker').offsetWidth;
				console.log("PreScaled IMG Width: " + preImgWidth);
				var desiredStandardLength = 1000;

				var standardLength_ScaleFactor = desiredStandardLength / standardLength;
				// var postImgWidth = 
				clickable = document.getElementById('clicker');
				clickable.style.width = (preImgWidth*standardLength_ScaleFactor) + 'px';

				var newScaledWidth = preImgWidth*standardLength_ScaleFactor;

				

				console.log("NewScaledWidth: " + newScaledWidth);

				var newSquare_x = SquareLocation_x;
				var newSquare_y = SquareLocation_y;

				console.log("NewSquareX: " + newSquare_x);
				console.log("NewSquareY: " + newSquare_y);

				

				//clickable.style.display = 'none';
			}

			// if ((clickCounter > 3) && (clickCounter < 5)) {
			// 	var top_bottom_diffs_x = (Click_TopCorner_x - Click_BottomCorner_x);
			// 	var top_bottom_diffs_y = (Click_TopCorner_y - Click_BottomCorner_y);
			// 	var newScaledHeight = Math.sqrt((Math.pow(top_bottom_diffs_y,2))+(Math.pow(top_bottom_diffs_x,2)));

			// 	console.log("NewScaledHeight: " + newScaledHeight);
			// }



				var canvas = document.getElementById('myCanvas');
	     		var context = canvas.getContext('2d');
	      		var imageObj = new Image();

	      		var x = newScaledWidth;
	      		var y = 800;
	      		var newX = 500;
	      		var newY = 500;
	      		imageObj.onload = (function(xValue,yValue,newxValue,newyValue) {
	      			return function() {
	        
	        		// draw cropped image
	        		//var sourceX = 450;
	        		//var sourceY = 100;

	        		var sourceX = newX;
	        		var sourceY = newY;

	        		var sourceWidth = 100;
	        		var sourceHeight = 100;
	        		//var sourceHeight = 100;
	        		//var sourceWidth = preImgWidth*standardLength_ScaleFactor;
	        		var destWidth = x;
	        		var destHeight = y;
	        		var destX = canvas.width / 2 - destWidth / 2;
	        		var destY = canvas.height / 2 - destHeight / 2;

	        		context.drawImage(imageObj, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
	      		};
	      	})(x,y,newX,newY);
	      
	      		imageObj.src = '<?php echo $current_image; ?>';
			

				
		});

		</script>

		</main>
	</body>
</html>