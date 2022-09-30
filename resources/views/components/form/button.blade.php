@props([
    'px' => 'px-4',
    'no' => '1',
])
@php
    if ($no === '1') $bgColor = 'bg-indigo-500 hover:bg-indigo-600';
    if ($no === '2') $bgColor = 'bg-indigo-400 hover:bg-indigo-500';
    if ($no === '3') $bgColor = 'bg-gray-400 hover:bg-gray-500';
    if ($no === 'caution') $bgColor = 'bg-red-500 hover:bg-red-600';
@endphp


<button {{ $attributes->merge(['class' => "h-12 text-white  border-0 py-2 focus:outline-none  rounded {$bgColor} {$px}"]) }}>{{ $slot }}</button>
