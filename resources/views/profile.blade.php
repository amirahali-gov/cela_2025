@extends('Layouts.committee-layout')
@section('content')
    <div class="container-fluid">
        {{-- @dump($uploads->where('UPD_Desc', 'File_Birth_Certificate')->first()->UPD_FilePath) --}}
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
                            <label class="form-label fw-bold">Date of Birth</label>
                            <p class="mb-0">{{ $applicant->APL_DOB }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Age</label>
                            <p class="mb-0">{{ $applicant->APL_Age }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Contact Number</label>
                            <p class="mb-0">{{ $applicant->APL_PPhone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Alternative Contact Number</label>
                            <p class="mb-0">{{ $applicant->APL_APhone ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <p class="mb-0">{{ $applicant->APL_Email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Trinidad & Tobago National</label>
                            <p class="mb-0">{{ $applicant->APL_TT == 'N' ? 'No' : 'Yes' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Form of Identification</label>
                            <p class="mb-0">
                                @if ($applicant->APL_ID_TYP == 'NID')
                                    National ID
                                @elseif ($applicant->APL_ID_TYP == 'PP')
                                    Passport
                                @elseif ($applicant->APL_ID_TYP == 'DP')
                                    Driver's Permit
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Identification Number</label>
                            <p class="mb-0">{{ $applicant->APL_ID_Number }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Birth Certificate Pin</label>
                            <p class="mb-0">{{ $applicant->APL_BIRTH_PIN }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Preferred Region for Placement</label>
                            <p class="mb-0">{{ $applicant->APL_Service_Area }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">NIS Information</label>
                            <p class="mb-0">
                                @if ($applicant->APL_Has_NIS == 'Y')
                                    Yes - NIS Number: {{ $applicant->APL_NIS_Number }}
                                @else
                                    No
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Bank Account</label>
                            <p class="mb-0">
                                @if ($applicant->APL_BANK == 'Y')
                                    Yes<br>
                                    Institution:
                                    {{ $applicant->APL_BANK_Name == 'OTH' ? $applicant->APL_BANK_Other : $applicant->BANK_Desc }}<br>
                                    Account: {{ $applicant->APL_BANK_ACC }}
                                @else
                                    No
                                @endif
                            </p>
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
                            <label class="form-label fw-bold">Highest Level of Education</label>
                            <p class="mb-0">{{ $applicant->APL_HLOE ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Technical/Vocational Specification</label>
                            <p class="mb-0">{{ $applicant->APL_HLOE_Specify ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employment Status</label>
                            <p class="mb-0">
                                {{ $applicant->APL_Employment_Status == 'Y' ? 'Employed/Self-Employed' : 'Not Employed' }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Job Title</label>
                            <p class="mb-0">{{ $applicant->APL_Job_Title ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employment Type</label>
                            <p class="mb-0">{{ $applicant->APL_Employment_Type ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Two CXC Passes or More</label>
                            <p class="mb-0">{{ $applicant->APL_2_CXC_Passes == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Possesses a Certificate Reflecting Competencies in Geriatric
                                Care or Professional Healthcare</label>
                            <p class="mb-0">{{ $applicant->APL_Geriatric_Certif == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">From which institution did you receive your
                                certification?</label>
                            <p class="mb-0">{{ $applicant->APL_Graduate ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programme Interest Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Programme Interest & Availability</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Available Weekdays (8AM-4PM) Mondays to Fridays (except
                                Public Holidays)</label>
                            <p class="mb-0">{{ $applicant->APL_Available_Weekdays == 'N' ? 'No' : 'Yes' }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Please outline your experience in providing Geriatric Care
                            Services</label>
                        <p class="mb-0">{{ $applicant->APL_Experience }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivation & Expectations - Briefly describe why you are
                            interested in joining the National Service GAPP.</label>
                        <p class="mb-0">{{ $applicant->APL_Motivation_Expectations ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Feedback Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Feedback & Future Plans</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">After completing the 6 months National Service GAPP, do you
                                intend to</label>
                            <p class="mb-0">
                                @if ($applicant->APL_Post_Training_Intent == 'Seek employment')
                                    Seek employment in Geriatric Care
                                @elseif($applicant->APL_Post_Training_Intent == 'Continue studies')
                                    Continue studies in Healthcare
                                @elseif($applicant->APL_Post_Training_Intent == 'Start business')
                                    Start your own caregiving business
                                @elseif($applicant->APL_Post_Training_Intent == 'Other')
                                    Other: {{ $applicant->APL_Post_Training_Other ?? 'Not specified' }}
                                @elseif($applicant->APL_Post_Training_Intent)
                                    {{ $applicant->APL_Post_Training_Intent }}
                                @else
                                    Not provided
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">If other, please specify</label>
                            <p class="mb-0">{{ $applicant->APL_Post_Training_Other ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">I consent to be contacted by the Ministry of Sport and Youth
                                Affairs' Monitoring & Evaluation Unit up to two (2) years after programme completion for
                                tracer studies.</label>
                            <p class="mb-0">
                                {{ $applicant->APL_Consent_Followup == 'Y' ? 'Yes' : ($applicant->APL_Consent_Followup == 'N' ? 'No' : 'Not provided') }}
                            </p>
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
                            <label class="form-label fw-bold">If other, please specify</label>
                            <p class="mb-0">{{ $applicant->APL_How_Found_Other ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Would you like to be added to the Ministry of Sport and Youth
                                Affairs' mailing list?</label>
                            <p class="mb-0">
                                {{ $applicant->APL_Subscribe_Mailing == 'Y' ? 'Yes' : ($applicant->APL_Subscribe_Mailing == 'N' ? 'No' : 'Not provided') }}
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Consent to use your photo for promotional purposes</label>
                            <p class="mb-0">
                                {{ $applicant->APL_Photo_Consent == 'Y' ? 'Yes' : ($applicant->APL_Photo_Consent == 'N' ? 'No' : 'Not provided') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- References Section -->
        <section class="mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Professional Recommender 1</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $applicant->APL_Prof_Rec_FName }}
                                {{ $applicant->APL_Prof_Rec_LName }}</p>
                            <p><strong>Designation:</strong> {{ $applicant->APL_Prof_Rec_Designation }}</p>
                            <p><strong>Phone:</strong> {{ $applicant->APL_Prof_Rec_Phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Professional Recommender 2</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $applicant->APL_Prof_Rec_2_FName ?? 'Not provided' }}
                                {{ $applicant->APL_Prof_Rec_2_LName ?? '' }}</p>
                            <p><strong>Designation:</strong> {{ $applicant->APL_Prof_Rec_2_Designation ?? 'Not provided' }}
                            </p>
                            <p><strong>Phone:</strong> {{ $applicant->APL_Prof_Rec_2_Phone ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Documents Section -->
        <section class="mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Required Documents</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $documentTypes = [
                                'File_Birth_Certificate' => 'Birth Certificate',
                                'File_National_ID' => 'National Identification',
                                'File_Proof_Address' => 'Proof of Address',
                                'File_Authorization_Letter' => 'Letter of Authorization',
                                'File_Owner_ID' => 'Owner\'s ID',
                                'File_Geriatric_Certificate' => 'Geriatric Care Certificate',
                                'Files_Academic_Certificates' => 'Academic Certificates',
                                'File_Character_Certificate' => 'Police Certificate of Character',
                                'File_Recommender_Statement_1' => 'Recommender Statement 1',
                                'File_Recommender_Statement_2' => 'Recommender Statement 2',
                                'File_NIS_Card' => 'NIS Card',
                            ];
                        @endphp

                        @foreach ($documentTypes as $type => $label)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="border rounded p-3">
                                    <h6 class="fw-bold mb-2">{{ $label }}</h6>
                                    @if ($uploads !== null)
                                        @php $hasFiles = false; @endphp
                                        @foreach ($uploads as $upload)
                                            @if ($upload->UPD_Desc === $type)
                                                @php $hasFiles = true; @endphp
                                                <div class="mb-1">
                                                    <a href="{{ asset($upload->UPD_FilePath) }}" target="_blank"
                                                        class="text-decoration-none">
                                                        <small>{{ $upload->UPD_DocName }}</small>
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if (!$hasFiles)
                                            <small class="text-muted">No documents uploaded</small>
                                        @endif
                                    @else
                                        <small class="text-muted">No documents uploaded</small>
                                    @endif

                                    @if ($type === 'Certificate of Character' && $applicant->APL_CRN != null)
                                        <div class="mt-2">
                                            <small><strong>Receipt Number:</strong> {{ $applicant->APL_CRN }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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
                    </div>
                    @endif

                    @if ($chairman === 0)
                        <!-- Add Comments -->
                        <div class="mb-4">
                            <h5>Add Comments</h5>
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $applicant->APL_ID }}">
                                <textarea name="comment" id="comment" class="form-control" rows="4">
@if ($userComment !== null)
{{ $userComment->COM_Comment }}
@endif
</textarea>
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
                                        <label class="form-label">Evidence of Interest in Agriculture (0-6)</label>
                                        <input required type="number" name="score_interest" id="score" type="text" class="form-control"
                                            value="{{ $score->SCR_Score ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="scoreError"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Social Situation (0-5)</label>
                                        <input required type="number" name="score_social" id="score2" type="text" class="form-control"
                                            value="{{ $score->SCR_Score_2 ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="score2Error"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Education (0-6)</label>
                                        <input required type="number" name="score_education" id="score3" type="text" class="form-control"
                                            value="{{ $score->SCR_Score_3 ?? '' }}"
                                            {{ $applicant->APL_Dup === 'Y' || $applicant->APL_Scored === 'Y' ? 'disabled' : '' }}>
                                        <span class="text-danger"><em id="score3Error"></em></span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Personal Attributes (0-3)</label>
                                        <input required type="number" name="score_attributes" id="score4" type="text"
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
                            </form>
                    </div>
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
