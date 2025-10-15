@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">

        {{-- ===== Global toast-style alerts (success / error) ===== --}}
        @if (session('success'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        {{-- ======================================================= --}}

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Uploaded Files') }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="uploads_table" class="table table-striped table-border compact">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Filename</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $file)
                                <tr>
                                    <td>{{ $file['title'] }}</td>
                                    <td>{{ $file['filename'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Upload a GEO file') }}</div>
                <div class="card-body">
                    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="title">File Title</label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Enter title"
                                value="{{ old('title') }}"
                                required
                                aria-describedby="titleHelp"
                            >
                            <small id="titleHelp" class="form-text text-muted pb-2">
                                This is where you make a title for the file you're uploading
                            </small>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <input
                                    type="file"
                                    name="my_file"
                                    class="form-control-file @error('my_file') is-invalid @enderror"
                                    required
                                >
                                @error('my_file')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Table enhancement
        new DataTable('#uploads_table');

        // If there's an error, politely focus the title input so users know what to fix
        @if ($errors->has('title'))
            document.getElementById('title')?.focus();
        @endif
    });
</script>
@endsection
