@extends('Layouts.committee-layout')
@section('content')
    <div class="container-fluid">
        <!-- Scores Section -->
        @if ($score !== null)
            <section class="mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <div class="row align-items-center">
                            <h4 class="mb-0">YOUR SCORES</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5 class="mb-0 text-primary">{{ $applicant->APL_FName }} {{ $applicant->APL_MName }}
                                    {{ $applicant->APL_LName }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <h6 class="text-muted mb-2">Proven Interest</h6>
                                    <h3 class="text-danger mb-0">{{ $score->SCR_Score }}</h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <h6 class="text-muted mb-2">Social Situation</h6>
                                    <h3 class="text-danger mb-0">{{ $score->SCR_Score_2 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <h6 class="text-muted mb-2">Education</h6>
                                    <h3 class="text-danger mb-0">{{ $score->SCR_Score_3 }}</h3>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="text-center p-3 border rounded">
                                    <h6 class="text-muted mb-2">Personal Attributes</h6>
                                    <h3 class="text-danger mb-0">{{ $score->SCR_Score_4 }}</h3>
                                </div>
                            </div>
                        </div>
                        @if ($totalMean !== null)
                            <div class="text-center mt-3 pt-3 border-top">
                                <h5>Average Score: <span class="text-danger">{{ $totalMean }}</span></h5>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        <!-- Duplicate Flag Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Record Status</h5>
                </div>
                <div class="card-body">
                    <form name="update-duplicate" id="duplicate" method="post" action="{{ url('duplicate') }}">
                        @csrf
                        <p class="mb-3">Flag this record as a duplicate?</p>

                        <input type="hidden" name="applicantID" value="{{ $applicant->APL_ID }}">
                        <input type="hidden" name="user" value="{{ $user->LGN_Name }}">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="duplicateOptions" id="duplicateYes"
                                value="Y" {{ $applicant->APL_Dup == 'Y' ? 'checked' : '' }}>
                            <label class="form-check-label" for="duplicateYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="duplicateOptions" id="duplicateNo"
                                value="N" {{ $applicant->APL_Dup == 'N' ? 'checked' : '' }}>
                            <label class="form-check-label" for="duplicateNo">No</label>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Personal Information Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Personal Information</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h5 class="text-primary">{{ $applicant->APL_FName }} {{ $applicant->APL_MName }}
                                {{ $applicant->APL_LName }}</h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <p class="mb-0">
                                {{ $applicant->APL_Address_1 }}<br>
                                @if ($applicant->APL_Address_2)
                                    {{ $applicant->APL_Address_2 }}<br>
                                @endif
                                {{ $applicant->APL_Address_3 }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Gender</label>
                            <p class="mb-0">{{ $applicant->APL_Gender === 'F' ? 'Female' : 'Male' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Email Address</label>
                            <p class="mb-0">{{ $applicant->APL_Email }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <p class="mb-0">{{ $applicant->APL_PPhone }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alternative Contact Number</label>
                            <p class="mb-0">{{ $applicant->APL_APhone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Date of Birth</label>
                            <p class="mb-0">{{ $applicant->APL_DOB }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nationality</label>
                            <p class="mb-0">{{ $applicant->APL_Nationality ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Form of Identification</label>
                            <p class="mb-0">
                                @if ($applicant->APL_ID_TYP == 'NID')
                                    National Identification Card
                                @elseif ($applicant->APL_ID_TYP == 'PP')
                                    Passport
                                @else
                                    {{ $applicant->APL_ID_TYP ?? 'Not provided' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Identification Number</label>
                            <p class="mb-0">{{ $applicant->APL_ID_Number }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Birth Certificate Pin Number</label>
                            <p class="mb-0">{{ $applicant->APL_BIRTH_PIN }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education & Skills Background Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Education & Skills Background</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Highest Level of Education (Completed)</label>
                            <p class="mb-0">{{ $applicant->APL_HLOE ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Technical/Vocational Specification</label>
                            <p class="mb-0">{{ $applicant->APL_HLOE_Specify ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Number of CSEC Passes</label>
                            <p class="mb-0">{{ $applicant->APL_CSEC_Passes ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employment Status</label>
                            <p class="mb-0">{{ $applicant->APL_Employment_Type ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programme Interest Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Programme Interest</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">I am interested in attending this course:</label>
                            <p class="mb-0">{{ $applicant->APL_Programme ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Are you able to attend all scheduled sessions of the course?</label>
                            <p class="mb-0">{{ $applicant->APL_Attend == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    @if ($applicant->APL_Attend == 'N' && $applicant->APL_Attend_Explanation)
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">If no, please explain:</label>
                                <p class="mb-0">{{ $applicant->APL_Attend_Explanation }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Do you have any experience in make up?</label>
                            <p class="mb-0">{{ $applicant->APL_Experience == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    @if ($applicant->APL_Experience == 'Y' && $applicant->APL_Experience_Details)
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Experience Details:</label>
                                <p class="mb-0">{{ $applicant->APL_Experience_Details }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Consent & Additional Information Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Consent & Additional Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">I consent to be contacted by the Ministry of Sport and Youth Affairs Monitoring & Evaluation Unit up to two (2) years after programme completion for tracer studies.</label>
                            <p class="mb-0">{{ $applicant->APL_Contact_Consent == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">How did you find out about the programme?</label>
                            <p class="mb-0">
                                @if ($applicant->APL_How_Found_Programme == 'Social Media')
                                    Social Media
                                @elseif($applicant->APL_How_Found_Programme == 'TV/Radio/News')
                                    Television/Radio/Newspaper advertisements
                                @elseif($applicant->APL_How_Found_Programme == 'Website')
                                    Website
                                @elseif($applicant->APL_How_Found_Programme == 'Friend/Family')
                                    Friend or Family Member
                                @elseif($applicant->APL_How_Found_Programme == 'Other')
                                    Other: {{ $applicant->APL_How_Found_Other ?? 'Not specified' }}
                                @elseif($applicant->APL_How_Found_Programme)
                                    {{ $applicant->APL_How_Found_Programme }}
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Would you like to subscribe to the Ministry's mailing list for updates on upcoming projects and programmes?</label>
                            <p class="mb-0">{{ $applicant->APL_Subscribe == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">I agree to have my photographs or images used by the MSYA for promotion on all media pages.</label>
                            <p class="mb-0">{{ $applicant->APL_Photo_Consent == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Declaration Acceptance</label>
                            <p class="mb-0">{{ $applicant->APL_Accepts == 'Y' ? 'Applicant has read and accepted the declaration that the information provided is true and correct' : 'Not accepted' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Comments and Scoring Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Comments & Scoring</h4>
                </div>
                <div class="card-body">
                    <!-- Comment Thread -->
                    <div class="mb-4">
                        @if ($chairman === 1)
                            <h5>Comment Thread</h5>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col" class="fw-semibold">Date</th>
                                            <th scope="col" class="fw-semibold">Comment</th>
                                            <th scope="col" class="fw-semibold">Judge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($comment !== null)
                                            @foreach ($comment as $com)
                                                <tr>
                                                    @if ($chairman === 0)
                                                        @if ($score !== null && $com->LGN_ID == $score->LGN_ID)
                                                            <td><em>{{ $com->created_at }}</em></td>
                                                            <td>{{ $com->COM_Comment }}</td>
                                                            <td><span class="text-danger">{{ $com->LGN_Name }}</span></td>
                                                        @elseif($score === null)
                                                        @endif
                                                    @else
                                                        <td><em>{{ $com->created_at }}</em></td>
                                                        <td>{{ $com->COM_Comment }}</td>
                                                        <td><span class="text-danger">{{ $com->LGN_Name }}</span></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    @if ($chairman === 0)
                        <!-- Add Comments -->
                        <div class="mb-4">
                            <h5>Add Comments</h5>
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $applicant->APL_ID }}">
                                <textarea name="comment" id="comment" class="form-control" rows="4">@if ($userComment !== null){{ $userComment->COM_Comment }}@endif</textarea>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Scoring Section -->
                    <div class="scoring-section">
                        <h5>Scores</h5>

                        @if ($chairman === 0)
                            <form action="{{ route('score') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $applicant->APL_ID }}">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Evidence of Interest in Make Up Artistry (0-6)</label>
                                        <input required type="number" name="score_interest" id="score" class="form-control"
                                            value="{{ $score->SCR_Score ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="scoreError"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Social Situation (0-5)</label>
                                        <input required type="number" name="score_social" id="score2" class="form-control"
                                            value="{{ $score->SCR_Score_2 ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="score2Error"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Education (0-6)</label>
                                        <input required type="number" name="score_education" id="score3" class="form-control"
                                            value="{{ $score->SCR_Score_3 ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="score3Error"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Personal Attributes (0-3)</label>
                                        <input required type="number" name="score_attributes" id="score4"
                                            class="form-control" value="{{ $score->SCR_Score_4 ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="score4Error"></em></span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary"
                                        {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        Submit Score
                                    </button>
                                </div>
                            </form>
                        @endif

                        @if ($chairman != 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Judge</th>
                                            <th>Interest in Agriculture</th>
                                            <th>Social Situation</th>
                                            <th>Education</th>
                                            <th>Personal Attributes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($calculateScores !== null)
                                            @foreach ($calculateScores as $com)
                                                <tr>
                                                    @if ($chairman === 1)
                                                        <td><em>{{ $com->LGN_Name }}</em></td>
                                                        <td><input class="chairmanScore form-control" type="text"
                                                            value="{{ $com->SCR_Score }}" id="{{ $com->LGN_ID }}Score" required>
                                                        </td>
                                                        <td><input class="chairmanScore form-control" type="text"
                                                            value="{{ $com->SCR_Score_2 }}"
                                                            id="{{ $com->LGN_ID }}Score2" required></td>
                                                        <td><input class="chairmanScore form-control" type="text"
                                                            value="{{ $com->SCR_Score_3 }}"
                                                            id="{{ $com->LGN_ID }}Score3" required></td>
                                                        <td><input class="chairmanScore form-control" type="text"
                                                            value="{{ $com->SCR_Score_4 }}"
                                                            id="{{ $com->LGN_ID }}Score4" required></td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm"
                                                                onClick="changeScores('{{ $com->APL_ID }}','{{ $com->LGN_ID }}')"
                                                                {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                                                Change Scores
                                                            </button>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
