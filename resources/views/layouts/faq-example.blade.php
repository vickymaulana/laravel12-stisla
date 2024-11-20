@extends('layouts.app')

@section('title', 'FAQ Page')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>FAQ Page</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-lead">
                Below are some of the most frequently asked questions. Feel free to contact us if you have further questions.
            </p>

            <div class="faq">
                <div class="faq-item">
                    <h4 class="faq-question">What is this website about?</h4>
                    <p class="faq-answer">
                        This website provides a platform for users to access various features and information tailored to their needs.
                    </p>
                </div>
                <div class="faq-item">
                    <h4 class="faq-question">How do I register?</h4>
                    <p class="faq-answer">
                        You can register by clicking the "Sign Up" button at the top of the page and filling out the required information.
                    </p>
                </div>
                <div class="faq-item">
                    <h4 class="faq-question">Who can I contact for support?</h4>
                    <p class="faq-answer">
                        You can reach out to our support team via the "Contact Us" page or by emailing support@example.com.
                    </p>
                </div>
                <div class="faq-item">
                    <h4 class="faq-question">What are the terms and conditions?</h4>
                    <p class="faq-answer">
                        You can read our terms and conditions on the "Terms and Conditions" page linked in the footer of the website.
                    </p>
                </div>
                <div class="faq-item">
                    <h4 class="faq-question">How do I reset my password?</h4>
                    <p class="faq-answer">
                        To reset your password, click "Forgot Password" on the login page and follow the instructions.
                    </p>
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
