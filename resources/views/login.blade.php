@extends('Layouts.committee-layout')
@section('content')
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="bg-plum-plate bg-animation">
            <div class="d-flex justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-8">
                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                            <div class="modal-body">
                                <header class="h5 modal-title text-center">
                                    <h4 class="mt-2">
                                        <div>Login to Review Applicants</div>
                                    </h4>
                                </header>

                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <!-- Error message display -->
                                            <div class="position-relative form-group text-center">
                                                <label class="card-title">
                                                    <span class="text-danger error" id="error"></span>
                                                </label>
                                            </div>

                                            <!-- Username field -->
                                            <div class="position-relative form-group">
                                                <label class="card-title">
                                                    <span class="text-danger">*</span> Username
                                                </label>
                                                <input name="username" id="username" placeholder="" type="text"
                                                    class="form-control" required>
                                            </div>

                                            <!-- Password field -->
                                            <div class="position-relative form-group">
                                                <label class="card-title">
                                                    <span class="text-danger">*</span> Password
                                                </label>
                                                <input name="password" id="password" placeholder="" type="password"
                                                    class="form-control" required>
                                            </div>

                                            <!-- Login button -->
                                            <div class="position-relative form-group">
                                                <button type="submit"
                                                    class="btn-wide btn-pill btn-shadow btn-hover-shine btn btn-primary btn-lg"
                                                    id="Login">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center text-white opacity-8 mt-3">Copyright © MSYA 2022</div>
                </div>
            </div>
        </div>
    </div>
@endsection
