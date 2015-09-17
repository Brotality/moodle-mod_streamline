
<script type="text/javascript" src="<?php Print($moodle_dir);?>/mod/streamline/3rd-party.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="streamline.css">



<body>
<div id ="top_liveView">
		<div id="recordStatus" class="recordStatus_Off"> This Lecture is not being recorded </div>
	</div>
	<div class="units-row units-split">
	
		<!-- Container for the webinar/ BigBlueButton-->
		<div class="unit-75" id="middleContainer">
			<div id="liveView">
				<?php 
				$ipaddress = trim($CFG->ServerURLforBigBlueButton);
				$variable2 = substr($ipaddress, 0, strpos($ipaddress, "b"));
				$variable = trim(trim($variable2),'/').'/';
				?>
				
				<div id="flashclient" style="background-color:#EEEEEE;height:100%;width:100%;float:left;">
				   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="50%" id="BigBlueButton" name="BigBlueButton" align="middle">
					  <param name="movie" value="<?php Print($variable);?>client/BigBlueButton.swf?v=216" />
					  <param name="quality" value="high" />
					  <param name="allowfullscreen" value="true" />
					  <param name="bgcolor" value="#869ca7" />
					  <param name="wmode" value="window" />
					  <param name="allowScriptAccess" value="always" />
					 
						<object type="application/x-shockwave-flash" data="<?php Print($variable); ?>client/BigBlueButton.swf?v=VERSION" width="100%" height="100%" align="middle">
						  <param name="quality" value="high" />
						  <param name="bgcolor" value="#869ca7" />
						  <param name="allowScriptAccess" value="always" />
						  
							<a href="http://www.adobe.com/go/getflashplayer">
							  <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
							</a>
						 
					   </object>
				   
					</object>
				</div>
				
			</div>
			
			
			<div id="recordingView">
				<div id="sectionContainer"></div>
				<iframe id='streamline_recording' width='100%' height='100%' frameborder='0' scrolling='no' marginheight='0' marginwidth='0'></iframe>
			</div>
			<div id="optionView">
				<div class = "option_button playback_button">View Recording</div>
				<div class = "option_button live_button">Start Session</div>
			</div>
		</div>
		<div  class="unit-25" id="rightContainer">
			<div id="webinar_buttons">
				<div id="std_button" class="fullscreen_button">
					<img src="./images/fullscreen_button.png" style='width: 100%; object-fit: contain; visibility:hidden' />
				</div>
				<div id="std_button" class="quiz_button">
					<img src="./images/fullscreen_button.png" style='width: 100%; object-fit: contain; visibility:hidden' />
				</div>
				<div id="std_button" class="leave_button">
					<img src="./images/fullscreen_button.png" style='width: 100%; object-fit: contain; visibility:hidden' />
				</div>
			</div>
			<!-- Loads the chat module-->
			<div id="chat_module">
					<?php include 'Chat/Chat.php';?>
			</div>
			
			<div id="button_handler">
				<!-- Handles the buttons quiz, leave & full screen-->
				<?php include 'BBB/BBB.php';?>
			</div>
		</div>
	</div>
    <div id="update-display"/>
	<!-- Loads the forum module-->
    <div id="notifications" aria-live="polite" role="region" aria-label="Chat Notifications"></div>
	<?php include 'Forums/Forum.php';?>
	
</body>