@props(['status' => 'info'])
@php
    if ($status === 'info') $bgColor = 'bg-blue-300';
    if ($status === 'alert') $bgColor = 'bg-red-400';
@endphp

<div class="mx-16 my-6 px-8 py-6 text-center text-white {{ $bgColor }}">{!! nl2br( e($attributes->get('message')) ) !!}</div>
