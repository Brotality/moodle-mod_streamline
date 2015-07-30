<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link rel="stylesheet" href="webrtc_webinar/css/main.css" type="text/css">
<script src="webrtc_webinar/scripts/latest.js"></script>

<div>
	<button id="startButton">Start</button>
	<button id="stopButton">Stop</button>
<!--
	<button id="shareScreenButton">Share Screen</button>
	<button id="stopSharingButton">Stop Sharing</button>
-->

</div>

<video id="localVideo"></video>
<div id="remoteVideo"></div>

<script src="webrtc_webinar/scripts/webinar_functions.js"></script>

<script type="text/javascript">
	//http://simplewebrtc.com/latest.js
	/* variables and function defined in webinar_functions.js */
	startButton.addEventListener("click", startLiveStream);
	stopButton.addEventListener("click", stopLiveStream);
	//shareScreenButton.addEventListener("click", shareScreen);
	//stopSharingButton.addEventListener("click", stopSharing);

	user = <?= json_encode($USER); ?>;
	course = <?= json_encode($COURSE); ?>;
	isTeacher = <?= json_encode(user_has_role_assignment($USER->id, 3)); ?>;
	
	initialiseElements();
	connectToCourseLiveStream();
</script>