@extends('layouts.app')

@section('title', 'Todo Example')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Todo Example</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Todo Example</h2>
            <p class="section-lead">
                This page is an example of using a todo list.
            </p>
            <ul class="list-group">
                <li class="list-group-item">Task 1</li>
                <li class="list-group-item">Task 2</li>
                <li class="list-group-item">Task 3</li>
            </ul>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush