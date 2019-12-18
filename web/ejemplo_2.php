<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!-- Stream video via webcam -->
        <div class="video-wrap">
            <video id="video" playsinline autoplay></video>
        </div>

        <!-- Trigger canvas web API -->
        <div class="controller">
            <button id="snap">Capture</button>
        </div>
		<div id="error">
		</div>

        <!-- Webcam video snapshot -->
        <canvas id="canvas" width="640" height="480"></canvas>
        <script>
            'use strict';

            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const snap = document.getElementById("snap");
            const errorMsgElement = document.getElementById("error");

            const constraints = {
                video: {
                    width: 1280, height: 720
                }
            };

// Access webcam
            async function init() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
                }
            }

// Success
            function handleSuccess(stream) {
                window.stream = stream;
                video.srcObject = stream;
            }

// Load init
            init();

// Draw image
            var context = canvas.getContext('2d');
            snap.addEventListener("click", function () {
                context.drawImage(video, 0, 0, 640, 480);
            });
        </script>
    </body>
</html>
