<?php 
	include 'snippets/header.php';
	include 'snippets/main.php';

	$current_image = $_GET['image'];
?>

	<p class="lead">You are currently rescaling <span class="small"><strong><em><?php echo $current_image; ?></em></strong></span>
		<br />
		<!--<span style="margin-left: 15px;"></span> (1) Use your mouse to click on the <em>tip of the snout</em>.<br />
		<span style="margin-left: 15px;"></span> (2) Make a second click at the <em>posterior end of the midlateral portion of the hypural plate</em>.<br />
		See <a href="instructions.php" target="_blank">instructions here</a> for a schematic outlining the <strong>Standard Length (SL)</strong> measurement.<br />
		<em>Once you have made both clicks, the fish image will automatically rescale to have a <strong>SL</strong> of 1000px. Click <mark><strong>Subsample Fish Pattern <i class="far fa-arrow-alt-circle-right"></i></strong></mark> to continue.</em>-->
	</p>

	<p></p>
	<div id="cropButton"></div>
	<p></p>

	<div class='clickable' id='clicker'>
		<span class='display'></span>
		<img src="<?php echo $current_image; ?>" id="fishSample" width="100%" height="100%" />
	</div>

	<div id="img-out"></div>

	<script>
		var Hor_ClickOne_x = 0;
		var Hor_ClickOne_y = 0;

		var Hor_ClickTwo_x = 0;
		var Hor_ClickTwo_y = 0;

		var clickCounter = 0;

		clickable = document.getElementById('clicker');
		clickable.style.backgroundSize = 'contain';
		clickable.style.backgroundRepeat = 'no-repeat';

		$('.clickable').bind('click', function (ev) {
			
			console.log("Clicks: " + clickCounter);

			if (clickCounter == 0) {
				var $div = $(ev.target);
				var $display = $div.find('.display');

				var offset = $div.offset();

				Hor_ClickOne_x = ev.clientX - offset.left;
				Hor_ClickOne_y = ev.clientY - offset.top;

				$display.text('Horizontal SL Click 1: ' + 'x: ' + Hor_ClickOne_x + ', y: ' + Hor_ClickOne_y);

				var color = '#f47742';
        		var size = '15px';
        		var radius = '15px';
        		$(".clickable").append(
            		$('<div></div>')
                	.css('position', 'absolute')
                	.css('top', Hor_ClickOne_y + 'px')
                	.css('left', Hor_ClickOne_x + 'px')
                	.css('width', size)
                	.css('height', size)
                	.css('borderRadius', radius)
                	.css('background-color', color)
        		);
			} else if (clickCounter == 1) {
				var $div = $(ev.target);
				var $display = $div.find('.display');

				var offset = $div.offset();

				Hor_ClickTwo_x = ev.clientX - offset.left;
				Hor_ClickTwo_y = ev.clientY - offset.top;

				$display.text('Horizontal SL Click 2: ' + 'x: ' + Hor_ClickTwo_x + ', y: ' + Hor_ClickTwo_y);

				var color = '#f47742';
        		var size = '15px';
        		var radius = '15px';
				$(".clickable").append(
            		$('<div></div>')
                	.css('position', 'absolute')
                	.css('top', Hor_ClickTwo_y + 'px')
                	.css('left', Hor_ClickTwo_x + 'px')
                	.css('width', size)
                	.css('height', size)
                	.css('borderRadius', radius)
                	.css('background-color', color)
        		);

        		var clickWidth = $('#clicker').width();
				var clickHeight = $('#clicker').height();

				$(".clickable").append(
					$('<svg width="'+clickWidth+'" height="'+clickHeight+'"><line x1="'+Hor_ClickOne_x+'" y1="'+Hor_ClickOne_y+'" x2="'+Hor_ClickTwo_x+'" y2="'+Hor_ClickTwo_y+'" stroke="#f47742" stroke-width="6" stroke-dasharray="5,5" /></svg>')
					.css('position','absolute')
        		);
			} else {
				console.log("All clicks have been recorded.");
			}
			
			clickCounter++;
			if ((clickCounter > 1) && (clickCounter < 3)) {
				// calculate distance between the two clicked points
				var Hor_diffs_x = (Hor_ClickOne_x - Hor_ClickTwo_x);
				var Hor_diffs_y = (Hor_ClickOne_y - Hor_ClickTwo_y);
				var standardLength = Math.sqrt((Math.pow(Hor_diffs_y,2))+(Math.pow(Hor_diffs_x,2)));
				console.log("SL: " + standardLength);

				var orignalWidth = $('#clicker').width();
				var originalHeight = $('#clicker').height();
				console.log("Original Width: " + orignalWidth);
				console.log("Original Height: " + originalHeight);

				// calculate new scale factor
				var desiredStandardLength = 1000;
				var standardLength_ScaleFactor = desiredStandardLength / standardLength;
				
				var newScaledWidth = orignalWidth * standardLength_ScaleFactor;
				var newScaledHeight = originalHeight * standardLength_ScaleFactor;

				console.log("New Scaled Width: " + newScaledWidth);
				console.log("New Scaled Height: " + newScaledHeight);

				//document.getElementById("fishSample").width = newScaledWidth;
				//document.getElementById("fishSample").height = newScaledHeight;

				
				html2canvas($('#clicker')[0], {
  					scale:1
				}).then(function(canvas) {
					//var ctx = canvas.getContext('2d');
  					//ctx.fillStyle = "#f47742";
  					//ctx.beginPath();
  					//var shifted_horclickone_x = (Hor_ClickOne_x - 12);
  					//console.log(shifted_horclickone_x);
    				//ctx.arc(shifted_horclickone_x, Hor_ClickOne_y, 2, 0, Math.PI * 2, true);
    				//ctx.fill();

  					$("#img-out").append(canvas);
  					clickable.style.display = 'none';
  					
				});
				
				document.getElementById("cropButton").innerHTML+= "<a href='crop_fish.php?image=<?php echo $current_image; ?>&swidth=" + newScaledWidth + "&sheight=" + newScaledHeight + "'class='btn btn-primary btn-lg' role='button'>Subsample Fish Pattern <i class='far fa-arrow-alt-circle-right'></i></a>";			
			}		
		});
	</script>