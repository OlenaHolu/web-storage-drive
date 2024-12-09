@extends('partials.base')
@section('content')
<div class="storage-container">
    <h1>Almacenamiento Usado</h1>
    <p><strong>Espacio usado:</strong> {{ $totalStorageUsedInGB }} GB de {{ $storageLimitInGB }} GB</p>
    <div class="progress-bar-container" style="margin-top: 20px;">
        <div class="progress-bar" style="width: {{ $storagePercentageUsed }}%; background-color: #4caf50; height: 25px;">
            <span style="color: white; padding-left: 10px;">{{ $storagePercentageUsed }}%</span>
        </div>
    </div>
</div>

<style>
    .progress-bar-container {
        width: 100%;
        background-color: #f3f3f3;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }
</style>
@endsection