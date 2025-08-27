@extends('Layouts.layout')
@section('content')
    <div class="container-sm text-center justify-center items-center mt-4 p-4" style="height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-4">
                <a href="https://www.msya.gov.tt">
                    <img src="{{ asset('images/msya-logo.png') }}" alt="GAPP Logo" class="img-fluid ">
                </a>
                <hr>
                <h1 class="text-2xl font-bold">Application is closed</h1>
                <p class="text-lg">Thank you for your interest in the Geriatric Adolescent Partnership Programme. The application is currently
                    closed.
                    Please visit our <a
                        href="https://www.msya.gov.tt/our-programmes/gapp-geriatric-adolescent-partnership-programme/">website</a> or
                    email us at <a href="mailto:info@mydns.gov.tt">info@mydns.gov.tt</a> for more information.</p>
            </div>
        </div>
    </div>
@endsection