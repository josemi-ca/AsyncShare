@include('common_header')

    <div class="p-5 text-center bg-body-tertiary rounded-3">
        <video controls autoplay playsinline style="display: none"></video>
        <h1 class="text-body-emphasis">Grabe su pantalla</h1>
        <p class="col-lg-8 mx-auto fs-5 text-muted">Tras finalizar la grabación, obtendrá un enlace que podrá compartir asíncronamente.
        </p>
        <div class="d-inline-flex gap-2 mb-5">

            <button class="d-inline-flex align-items-center btn btn-success btn-lg px-4 rounded-pill" type="button" id="btn-start-recording">
                Iniciar grabación
            </button>
            <button class="btn btn-outline-danger btn-lg px-4 rounded-pill" type="button" id="btn-stop-recording" disabled style="display: none">
                Finalizar grabación
            </button>
        </div>
        <div class="spinner-grow text-danger" role="status" id="recordingMessage" style="display:none;">
            <span class="visually-hidden">Grabando...</span>
        </div>
        <div class="spinner-border" role="status" id="uploadingMessage" style="display:none;">
            <span class="visually-hidden">Procesando...</span>
        </div>
    </div>

<br>
    <div class="alert alert-info" role="alert"  id="uploadResult" style="display: none">

        <form class="row g-3">
            <div class="col-7">
                <input type="text" readonly class="form-control" id="videoPathInput">
            </div>
            <div class="col-5">
                <button onclick="copyVideoPath()" class="btn btn-primary mb-3">Copiar enlace</button>
                <a href="#" id="emailVideo" target="_blank"><button class="btn btn-secondary mb-3">Enviar enlace</button></a>
            </div>
        </form>
    </div>
<br>
@include('common_footer')




