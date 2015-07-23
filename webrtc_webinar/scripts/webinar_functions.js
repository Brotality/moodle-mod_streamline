/* Variables */

var webrtc = null;
var isTeacher = false;
var user = null;
var course = null;

var localVideo = document.getElementById("localVideo");
var remoteVideo = document.getElementById("remoteVideo");

var startButton = document.getElementById("startButton");
var stopButton = document.getElementById("stopButton");

var shareScreenButton = document.getElementById("shareScreenButton");
var stopSharingButton = document.getElementById("stopSharingButton");
/* Functions */

function initialiseElements(){
    if(isTeacher == false){
        startButton.style.display = "none";
        stopButton.style.display = "none";
        shareScreenButton.style.display = "none";
        stopSharingButton.style.display = "none";
        localVideo.style.display = "none";
    } else {
        stopButton.style.display = "none";
        shareScreenButton.style.display = "none";
        stopSharingButton.style.display = "none";
    }
}

function toggleButtons(buttons){
    for(button of buttons){
        button.style.display = (button.style.display == "none") ? "block" : "none";
    }
}

// create new SimpleWebRTC object and connect to course room
function connectToCourseLiveStream(){
    webrtc = new SimpleWebRTC({
        localVideoEl: 'localVideo',
        remoteVideosEl:'remoteVideo',
        autoRequestMedia: false,
        localVideo: {
            autoplay: true,
            mirror: false,
            muted: true
        }
    });
    webrtc.joinRoom("streamlineRTC".concat(course.shortname));
}

function startLiveStream(){
    if(webrtc.roomName == null){
        webrtc.joinRoom("streamlineRTC".concat(course.shortname));
    }
    // start local media access
    webrtc.startLocalVideo();
    toggleButtons([startButton, stopButton]);
    shareScreenButton.style.display = "block";
}

function stopLiveStream(){
    // if in a room, leave
    if(webrtc != null && webrtc.roomName != null){
        webrtc.leaveRoom();
        // stop local media access
        webrtc.stopLocalVideo();
    }
    toggleButtons([startButton, stopButton]);
    shareScreenButton.style.display = "none";
}

function shareScreen(){
    webrtc.shareScreen();
    toggleButtons([shareScreenButton, stopSharingButton]);
}

function stopSharing(){
    webrtc.stopScreenShare();
    toggleButtons([shareScreenButton, stopSharingButton]);
}