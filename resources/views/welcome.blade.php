@extends('layouts.app')

@section('main-class','p-0')

@section('content')
<div class="min-h-[calc(100vh-64px)] flex items-center justify-center text-center relative overflow-hidden">
  <div class="reveal max-w-3xl px-6">
    <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
      AI-Powered <span class="text-accent">Warehouse Delivery Alerts</span>
    </h1>
    <p class="mt-4 text-white/80 text-lg">
      Revolutionize your logistics with intelligent proximity detection, advanced geospatial math, and real-time tracking.
    </p>
    <div class="mt-8 flex justify-center gap-4">
      <a href="/proximity-form" class="btn-gradient">Open Dashboard</a>
    </div>

    <div class="mt-8 flex items-center justify-center gap-3">
      <span class="chip">⚡ Real-time</span>
      <span class="chip">🔒 Secure</span>
      <span class="chip">📈 Analytics</span>
    </div>
  </div>
</div>
@endsection
