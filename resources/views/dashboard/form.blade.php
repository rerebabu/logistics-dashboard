@extends('layouts.app')

{{-- full-bleed to let background cover edge-to-edge --}}
@section('main-class','p-0')

@section('content')
{{-- Background --}}
<div class="min-h-[calc(100vh-64px)] w-full bg-smart-blue relative">

  {{-- Split screen container --}}
  <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-10 gap-8">

    {{-- MAP column (70%) --}}
    <section class="lg:col-span-7 card-solid p-4 relative reveal">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold">Interactive Map</h2>
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center gap-2 chip">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            Live
          </span>
        </div>
      </div>
      <div id="map" class="w-full min-h-[400px] h-[65vh] block rounded-2xl overflow-hidden"></div>

      {{-- radius legend --}}
      <div class="absolute bottom-4 left-4 chip">Radius:
        <span id="radiusLabel" class="ml-1 text-accent font-semibold">250 m</span>
      </div>
    </section>

    {{-- FLOATING FORM column (30%) --}}
    <aside class="lg:col-span-3 space-y-6">
      <div class="card-glass p-6 reveal">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-accent to-accent-2 grid place-items-center">
            <svg width="18" height="18" viewBox="0 0 24 24"><path fill="white" d="M12 2L3 6v12h18V6L12 2z"/></svg>
          </div>
          <div>
            <h3 class="text-xl font-bold">Proximity Detection</h3>
            <p class="text-white/70 text-sm">Enter coordinates or use the map</p>
          </div>
        </div>

        <form method="POST" action="{{ route('check.proximity') }}" id="proxForm" class="space-y-4">
          @csrf
          <div>
            <label class="block text-sm mb-1">Latitude</label>
            <input id="lat" name="lat" type="text" value="{{ old('lat') }}" required
                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-accent"
                   placeholder="e.g., 14.599512">
          </div>

          <div>
            <label class="block text-sm mb-1">Longitude</label>
            <input id="lng" name="lng" type="text" value="{{ old('lng') }}" required
                   class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-2 outline-none focus:border-accent"
                   placeholder="e.g., 120.984219">
          </div>

          <div>
            <label class="block text-sm mb-2">Detection Radius <span class="text-white/60">(meters)</span></label>
            <input id="radiusRange" type="range" min="100" max="500" step="50" value="{{ old('radius',250) }}"
                   class="w-full accent-[var(--color-accent)]">
            <div class="mt-1 text-sm">Selected: <span id="radiusText" class="text-accent font-semibold">250</span> m</div>
            <input type="hidden" name="radius" id="radiusHidden" value="{{ old('radius',250) }}">
          </div>

          {{-- Instant accuracy estimate (demo calc in JS) --}}
          <div class="text-sm text-white/80">
            Estimated accuracy: <span id="estAcc" class="font-semibold text-accent">99.2%</span>
          </div>

          <button type="submit" class="btn-gradient w-full">Analyze Proximity</button>
        </form>

        @if($errors->any())
          <div class="mt-3 text-red-400 text-sm">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif
      </div>

        {{-- Metrics bar --}}
        <div class="card-glass p-5 grid grid-cols-3 gap-4 reveal">
            <div>
            <div class="text-2xl font-bold">99.9%</div>
            <div class="text-xs text-white/70">Accuracy</div>
            </div>
            <div>
            <div class="text-2xl font-bold">&lt;50ms</div>
            <div class="text-xs text-white/70">Response</div>
            </div>
            <div>
            <div class="text-2xl font-bold">24/7</div>
            <div class="text-xs text-white/70">Availability</div>
            </div>
        </div>


      {{-- Status chips --}}
      <div class="flex flex-wrap gap-2 reveal">
        <span class="chip">🚚 Deliveries: <span id="deliveriesCount" class="text-accent ml-1">12</span></span>
        <span class="chip">🛎 Alerts today: <span id="alertsCount" class="text-accent ml-1">3</span></span>
        <span class="chip" id="liveChip">● Live</span>
      </div>
    </aside>
  </div>
</div>
</div>

{{-- Include map JS --}}
@vite('resources/js/map.js')

<script>
document.addEventListener("DOMContentLoaded", function () {
    window.Echo.channel('location-tracking')
        .listen('LocationUpdated', (e) => {
            console.log("New location received:", e);
        });

    initMap();
});
</script>
@endsection
