<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AsyncShare</title>
    <style>
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 1em;
        }

        video {
            width: 30%;
            border-radius: 5px;
            border: 1px solid black;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

<h1>Grabe su pantalla</h1>

<br>

<button id="btn-start-recording" class="btn btn-success" >Iniciar grabación</button>
<button id="btn-stop-recording" disabled class="btn btn-danger" style="display: none">Finalizar grabación</button>

<hr>
<video controls autoplay playsinline style="display: none"></video>


<div id="uploadingMessage" style="display:none;">Procesando...</div>

<section id="uploadResult" style="display: none">
    <input type="text" id="videoPathInput">
    <button onclick="copyVideoPath()">Copiar enlace</button>
</section>

<script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
<script src="https://www.webrtc-experiment.com/common.js"></script>
<script src="js/recording/recording.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
