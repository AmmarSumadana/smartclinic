{{-- resources/views/components/app-layout.blade.php --}}
@props(['header' => null])
@include('layouts.template', ['slot' => $slot])
