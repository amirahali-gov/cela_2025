@extends('Layouts.layout')
@section('content')
    <div class="container-sm text-center justify-center items-center mt-4 p-4" style="height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-4">
                <a href="https://www.msya.gov.tt">
                    <img src="{{ asset('images/msya-logo.png') }}" alt="MSYA Logo" class="img-fluid ">
                </a>
                <hr>
                <h1 class="text-2xl font-bold">Application is closed</h1>
                <p class="text-lg">Thank you for your interest in the Civic Engagement Leadership Academy 2026. The application is currently
                    closed.
                    Please visit our <a
                        href="https://www.msya.gov.tt/our-programmes">website</a> or
                    email us at <a href="mailto:info@msya.gov.tt">info@msya.gov.tt</a> for more information.</p>
            </div>
        </div>
    </div>
@endsection
