@php
    if (empty($filename)) $path = 'images/no_image.jpg';
    else $path = "storage/{$folder}/{$filename}";
@endphp
<img src="{{ url($path) }}" {{ $attributes() }}>
