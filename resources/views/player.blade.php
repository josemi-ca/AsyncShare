@include('common_header')




<div class="card">
    <div class="card-header">
        Ver grabación de pantalla
    </div>
    <div class="card-body">
        <video class="object-fit-contain w-100 h-100 border rounded"
               controls autoplay playsinline
               src="{{ Storage::url($video->path) }}"></video>
    </div>
</div>


@include('common_footer')
