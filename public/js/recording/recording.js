// Check for browser support for getDisplayMedia API
let video = document.querySelector('video');

if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
    let error = 'Navegador no soportado. Por favor, acceda desde un PC/Mac.'; //No getDisplayMedia API
    document.querySelector('h1').textContent = error;

    video.style.display = 'none';
    document.getElementById('btn-start-recording').style.display = 'none';
    document.getElementById('btn-stop-recording').style.display = 'none';
    throw new Error(error);
}

// Function to invoke getDisplayMedia API
function invokeGetDisplayMedia(success, error) {
    let displayMediaStreamConstraints = {
        video: {
            displaySurface: 'monitor', // monitor, window, application, browser
            logicalSurface: true, cursor: 'always' // never, always, motion
        }
    };

    // Override constraints as they are not yet supported
    displayMediaStreamConstraints = {
        video: true
    };

    if (navigator.mediaDevices.getDisplayMedia) {
        navigator.mediaDevices.getDisplayMedia(displayMediaStreamConstraints)
            .then(success)
            .catch(error);
    } else {
        navigator.getDisplayMedia(displayMediaStreamConstraints)
            .then(success)
            .catch(error);
    }
}

// Function to capture screen
function captureScreen(callback) {
    invokeGetDisplayMedia(function (screen) {
        addStreamStopListener(screen, function () {
            document.getElementById('btn-stop-recording').click();
        });
        callback(screen);
    }, function (error) {
        console.error(error);
        alert('Errror al capturar la pantalla. Revise los permisos.');
    });
}

// Callback function when recording stops
function stopRecordingCallback() {
    video.src = video.srcObject = null;
    video.src = URL.createObjectURL(recorder.getBlob());

    let blob = recorder.getBlob();
    let uploaded = uploadVideo(blob);

    recorder.destroy();
    recorder = null;

    document.getElementById('btn-start-recording').disabled = false;
    document.getElementById('btn-start-recording').style.display = 'inline-block';

}

// Function to upload recorded video
function uploadVideo(blob) {
    let uploadingMessage = document.getElementById('uploadingMessage');
    uploadingMessage.style.display = 'block';

    const formData = new FormData();
    formData.append('video', blob, 'recorded_video.webm');

    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    formData.append('_token', csrfToken);

    fetch('/upload-recording', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Failed to upload video');
            }
        })
        .then(data => {
            console.log('Video uploaded successfully:', data);
            uploadingMessage.style.display = 'none';
            document.getElementById('uploadResult').style.display = 'block';
            displayVideoPath(data.video_path);
        })
        .catch(error => {
            console.error('Error uploading video:', error);
            uploadingMessage.style.display = 'none';
            alert('Error de subida de video. Inténtelo de nuevo.');
        });
}

// Start recording button click event
document.getElementById('btn-start-recording').onclick = function () {
    this.disabled = true;

    document.getElementById('uploadResult').style.display = 'none';
    captureScreen(function (screen) {
        video.srcObject = screen;

        recorder = RecordRTC(screen, {
            type: 'video'
        });

        recorder.startRecording();
        recorder.screen = screen;

        document.getElementById('btn-stop-recording').disabled = false;
        document.getElementById('btn-start-recording').style.display = 'none';
        document.getElementById('btn-stop-recording').style.display = 'inline-block';
    });
};

// Stop recording button click event
document.getElementById('btn-stop-recording').onclick = function () {
    this.disabled = true;
    this.style.display = 'none';
    recorder.stopRecording(stopRecordingCallback);
};

// Add event listener for stream end or inactive
function addStreamStopListener(stream, callback) {
    ['ended', 'inactive'].forEach(event => {
        stream.addEventListener(event, callback, false);
    });

    stream.getTracks().forEach(function (track) {
        ['ended', 'inactive'].forEach(event => {
            track.addEventListener(event, callback, false);
        });
    });
}

// Display video path
function displayVideoPath(videoPath) {
    const videoPathInput = document.getElementById('videoPathInput');
    videoPathInput.value = videoPath;

    const emailVideo = document.getElementById('emailVideo');
    emailVideo.href = 'mailto:?body=' +videoPath;
}

// Copy video path to clipboard
function copyVideoPath() {
    const videoPathInput = document.getElementById('videoPathInput');
    videoPathInput.select();
    document.execCommand('copy');
    alert('Enlace copiado');
}
