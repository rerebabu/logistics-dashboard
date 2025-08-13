@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="text-center space-y-2">
        <span class="px-4 py-1 bg-green-900 text-green-300 text-xs font-semibold rounded-full">
            Analysis Complete
        </span>
        <h1 class="text-4xl font-extrabold text-white">
            Proximity <span class="text-gradient">Check</span>
        </h1>
        <p class="text-sm text-gray-400">
            Evaluating the delivery location and range status
        </p>
    </div>

    {{-- Status Card --}}
<div class="bg-gray-900/60 backdrop-blur-md rounded-2xl shadow-xl border border-gray-700 p-6 space-y-5">
    <div class="flex flex-col items-center space-y-2">
        <div class="p-3 {{ $data['within_range'] ? 'bg-green-500/20' : 'bg-red-500/20' }} rounded-full">
            @if($data['within_range'])
                {{-- Check Icon --}}
                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
            @else
                {{-- X Icon --}}
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            @endif
        </div>

        {{-- Dynamic Heading --}}
        <h2 class="text-xl font-bold {{ $data['within_range'] ? 'text-green-400' : 'text-red-400' }}">
            {{ $data['within_range'] ? 'Delivery Within Range' : 'Delivery Out of Range' }}
        </h2>

        {{-- Dynamic Description --}}
        <p class="text-gray-300 text-sm">
            {{ $data['within_range'] 
                ? 'This location is eligible for standard delivery.' 
                : 'Special handling or extra fees may apply.' 
            }}
        </p>
    </div>

        {{-- Metrics Grid --}}
        @if(isset($data))
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-gray-800 p-4 rounded-xl border border-gray-700 flex flex-col items-center">
                <div class="text-blue-400 text-lg font-bold">{{ $data['distance'] }} m</div>
                <div class="text-xs text-gray-400">Distance from Hub</div>
            </div>
            <div class="bg-gray-800 p-4 rounded-xl border border-gray-700 flex flex-col items-center">
                <div class="text-orange-400 text-lg font-bold">100 m</div>
                <div class="text-xs text-gray-400">Service Radius</div>
            </div>
            <div class="bg-gray-800 p-4 rounded-xl border border-gray-700 flex flex-col items-center">
                <div class="{{ $data['within_range'] ? 'text-green-400' : 'text-red-400' }} text-lg font-bold">
                    {{ $data['within_range'] ? 'APPROVED' : 'DENIED' }}
                </div>
                <div class="text-xs text-gray-400">Delivery Status</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Map & Errors --}}
    <div class="bg-gray-900/60 rounded-2xl shadow-lg border border-gray-700 overflow-hidden">
        @vite('resources/js/map.js')
        <div id="map" class="w-full h-[400px]"></div>
    </div>

    @if($errors->any())
    <div class="bg-red-900/60 border border-red-700 text-red-200 rounded-lg p-4">
        @foreach($errors->all() as $error)
            <p>⚠ {{ $error }}</p>
        @endforeach
    </div>
    @endif
</div>

{{-- Map Script --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        initMap(14.5995, 120.9842);

        @if(isset($lat) && isset($lng))
            updateDeliveryMarker({{ $lat }}, {{ $lng }}, true);
        @endif
    });
</script>

@endsection
