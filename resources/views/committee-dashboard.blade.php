@extends('Layouts.committee-layout')
@section('content')
    
    <div class="h5 modal-title">
        <h4 class="mt-2">
            <div>Applicant Listing</div>
            <span></span>
        </h4>
    </div>

    <div class="container">
        

        @include('components.data-table', [
            'applications' => $applications,
            'title' => 'All Applications',
            'user' => $user,
        ])
    </div>
@endsection
