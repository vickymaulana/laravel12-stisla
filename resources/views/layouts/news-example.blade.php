@extends('layouts.app')

@section('title', 'News Page')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>News Page</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Latest News</h2>
            <p class="section-lead">
                Stay updated with the latest news and updates from our platform.
            </p>

            <div class="row">
                <!-- Example News Item 1 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Breaking News: Feature Update</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                We are excited to announce the release of a new feature designed to enhance user experience. Click to learn more!
                            </p>
                        </div>
                        <div class="card-footer text-right">
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Example News Item 2 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Platform Maintenance Scheduled</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                Our platform will undergo maintenance on November 25th, 2024, from 12:00 AM to 6:00 AM UTC. Thank you for your patience.
                            </p>
                        </div>
                        <div class="card-footer text-right">
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>

                <!-- Example News Item 3 -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>User Stories: Success Highlight</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                Discover how one of our users leveraged our platform to achieve their goals. An inspiring story you don’t want to miss!
                            </p>
                        </div>
                        <div class="card-footer text-right">
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
