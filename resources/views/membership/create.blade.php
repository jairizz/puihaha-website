@extends('layouts.app')

@section('content')
<div class="application-page">
    <header class="application-header">
        <a href="{{ route('login') }}" class="application-brand"><span class="brand-mark">P</span><span><strong>Puihaha</strong><small>Membership Management System</small></span></a>
        <a href="{{ route('login') }}" class="secondary-btn">Administrator sign in</a>
    </header>

    <div class="application-intro">
        <span class="eyebrow">MEMBERSHIP APPLICATION</span>
        <h1>Join the Puihaha community.</h1>
        <p>Complete the form below and choose your location. We will send a confirmation email with your application reference.</p>
    </div>

    @include('partials.validation-errors')

    <form action="{{ route('membership.store') }}" method="POST" class="application-layout">
        @csrf
        <section class="form-card application-form-card">
            <div class="form-heading"><span class="eyebrow">YOUR DETAILS</span><h2>Tell us about yourself</h2><p>All fields marked with an asterisk are required.</p></div>
            <div class="form-grid">
                <div class="form-field full-field"><label for="full_name">Full name <span>*</span></label><input id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Juan Dela Cruz" required></div>
                <div class="form-field"><label for="email">Email address <span>*</span></label><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="juan@example.com" required></div>
                <div class="form-field"><label for="phone">Phone number</label><input id="phone" name="phone" value="{{ old('phone') }}" placeholder="09XX XXX XXXX"></div>
                <div class="form-field full-field"><label for="address">Address</label><textarea id="address" name="address" rows="3" placeholder="House number, street, city">{{ old('address') }}</textarea></div>
                <div class="form-field"><label for="membership_category_id">Membership category <span>*</span></label><select id="membership_category_id" name="membership_category_id" required><option value="">Choose a category</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('membership_category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                <div class="form-field"><label for="membership_level_id">Membership level <span>*</span></label><select id="membership_level_id" name="membership_level_id" required><option value="">Choose a level</option>@foreach($levels as $level)<option value="{{ $level->id }}" data-fee="{{ $level->fee }}" @selected(old('membership_level_id') == $level->id)>{{ $level->name }} — ₱{{ number_format($level->fee, 2) }}</option>@endforeach</select></div>
                <input id="latitude" type="hidden" name="latitude" value="{{ old('latitude', '14.5995') }}">
                <input id="longitude" type="hidden" name="longitude" value="{{ old('longitude', '120.9842') }}">
                <div class="form-actions full-field"><button class="primary-btn" type="submit"><i class="fa-solid fa-paper-plane"></i> Submit application</button></div>
            </div>
        </section>

        <section class="map-card">
            <div class="map-heading"><div><span class="eyebrow">LOCATION</span><h2>Choose your location</h2><p>Click anywhere on the map to update your coordinates.</p></div><i class="fa-solid fa-location-dot"></i></div>
            <div id="map" class="map-canvas"><div id="map-status" class="map-status"><i class="fa-solid fa-map"></i><span>Loading map...</span></div></div>
            <div class="coordinate-line"><span><i class="fa-solid fa-crosshairs"></i> <strong id="coordinates">14.59950, 120.98420</strong></span></div>
            <div class="weather-card"><div class="weather-icon"><i class="fa-solid fa-cloud-sun"></i></div><div><span>LIVE WEATHER</span><strong id="weather">Select a location to load the weather.</strong></div></div>
        </section>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let map;
    let marker;

    function loadWeather(lat, lon) {
        const weather = document.getElementById('weather');
        weather.textContent = 'Loading weather...';

        fetch(`{{ route('weather.show') }}?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`)
            .then(response => response.ok ? response.json() : Promise.reject())
            .then(data => {
                weather.textContent = `${data.place}: ${data.temperature ?? '--'}°C, ${data.description ?? 'Weather unavailable'}, humidity ${data.humidity ?? '--'}%`;
            })
            .catch(() => {
                weather.textContent = 'Weather is currently unavailable.';
            });
    }

    function setLocation(lat, lon) {
        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lon.toFixed(7);
        document.getElementById('coordinates').textContent = `${lat.toFixed(5)}, ${lon.toFixed(5)}`;

        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({ position: { lat, lng: lon }, map });
        loadWeather(lat, lon);
    }

    function initMap() {
        const lat = Number(document.getElementById('latitude').value) || 14.5995;
        const lon = Number(document.getElementById('longitude').value) || 120.9842;
        map = new google.maps.Map(document.getElementById('map'), { center: { lat, lng: lon }, zoom: 13, mapTypeControl: false, streetViewControl: false });
        document.getElementById('map-status')?.remove();
        map.addListener('click', event => setLocation(event.latLng.lat(), event.latLng.lng()));
        setLocation(lat, lon);
    }

    window.initMap = initMap;
</script>
@if(config('services.google_maps.key'))
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&loading=async&callback=initMap"></script>
@else
    <script>document.getElementById('map-status').querySelector('span').textContent = 'Add GOOGLE_MAPS_KEY to .env to load the map.';</script>
@endif
@endpush
