@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6">Proximity History</h1>

<div class="card-glass p-6 overflow-x-auto reveal">
  <table class="w-full text-sm">
    <thead class="text-white/70">
      <tr>
        <th class="text-left py-2">When</th>
        <th class="text-left py-2">Lat</th>
        <th class="text-left py-2">Lng</th>
        <th class="text-left py-2">Radius (m)</th>
        <th class="text-left py-2">Distance (m)</th>
        <th class="text-left py-2">Within?</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-white/10">
      @foreach($logs as $log)
      <tr>
        <td class="py-2">{{ $log->created_at->format('Y-m-d H:i') }}</td>
        <td class="py-2">{{ $log->lat }}</td>
        <td class="py-2">{{ $log->lng }}</td>
        <td class="py-2">{{ $log->radius }}</td>
        <td class="py-2">{{ number_format($log->distance,2) }}</td>
        <td class="py-2">
          @if($log->within_range)
          <span class="chip text-emerald-300 border-emerald-500/30">Within</span>
          @else
          <span class="chip text-rose-300 border-rose-500/30">Outside</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
