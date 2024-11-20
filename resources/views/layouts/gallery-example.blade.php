@extends('layouts.app')

@section('title', 'Gallery Example')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Gallery Example</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Gallery Example</h2>
            <p class="section-lead">
                This page is an example of using a gallery.
            </p>
            <div class="row">
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid" alt="Example Image">
                </div>
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid" alt="Example Image">
                </div>
                <div class="col-4">
                    <img src="https://via.placeholder.com/150" class="img-fluid" alt="Example Image">
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush