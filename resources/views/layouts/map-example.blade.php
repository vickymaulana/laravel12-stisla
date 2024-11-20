@extends('layouts.app')

@section('title', 'Map Example')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Map Example</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Map Example</h2>
            <p class="section-lead">
                This page is an example of using a map.
            </p>
            <div id="map" style="height: 400px;"></div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script>
    function initMap() {
        var mapOptions = {
            center: new google.maps.LatLng(-34.397, 150.644),
            zoom: 8
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    }
    google.maps.event.addDomListener(window, 'load', initMap);
</script>
@endpush