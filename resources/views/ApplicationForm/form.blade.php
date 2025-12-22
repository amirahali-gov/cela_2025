@extends('Layouts.layout')
@section('Title', 'Application Form')
@section('content')

    <body>
        <div id="background-panel-top"></div>
        <div id="background-panel-bottom"></div>

        <div id="application-form" class="container-fluid">

            <div id="form-panel">
                <div class="container text-center">
                    <img src="{{ asset('images/msya-logo.png') }}" alt="Logo" class="img-fluid w-25 mb-4" />
                </div>
                <section>
                    <div class="text-center">
                        <h1 id="sub-h1">NATIONAL SERVICE PROGRAMME</h1>
                        <h1>Civic Engagement Leadership Academy</h1>
                        <h1>CELA</h1><br><br>
                        <h2>A call for applications for The Civic Engagement Leadership Academy (CELA)</h2>
                    </div><br>

                    <div>

                        <p style="text-align: justify; text-indent: -2em; padding-left: 2em;">
                            The Civic Engagement Leadership Academy (CELA) is a flagship National Service initiative of the
                            Ministry of Sport and Youth Affairs (MSYA) designed to develop a new generation of responsible,
                            ethical, and service-oriented young leaders across Trinidad and Tobago. <br><br>
                        </p>

                        <p style="text-align: justify; text-indent: -2em; padding-left: 2em;">
                            CELA delivers a structured (6) six-month programme that integrates competency-based training,
                            civic education, leadership development, and supervised volunteer service. Through a blended
                            learning model, participants gain practical skills, civic awareness, and real-world experience
                            that prepare them to contribute meaningfully to their communities and the nation.<br><br>
                        </p>

                        <p style="text-align: justify; text-indent: -2em; padding-left: 2em;">
                            By combining classroom learning, applied skill-building, and hands-on community engagement, CELA
                            equips young people for active citizenship, community leadership, and improved employability,
                            while fostering national pride, social responsibility, and a commitment to service.<br><br>
                        </p>

                        <p style="text-align: justify;">
                            <strong>Requirements:</strong>
                            <ul>
                                <li>18-35 years</li>
                                <li>National of Trinidad and Tobago</li>
                                <li>Evidence of foundational literacy skills, such as a School Leaving Certificate or an
                                    equivalent qualification.</li>
                                <li>Applicants must be available to provide a <strong>minimum</strong> of 72 hours of volunteer
                                    service, to be completed within a period not exceeding three (3) months, following the
                                    successful completion of the programme’s training component.</li>
                                <li>All applicants must have access to a desktop or laptop computer with a reliable internet
                                    connection. The use of mobile phones is not recommended.</li>
                            </ul>

                            <strong>Applicants must submit the following documents when applying:</strong><br><br>
                            <ul>

                                <li>Copy of Birth Certificate</li>
                                <li>Copy of Academic and/or Skills Training Certificates (if available)</li>
                                <li>Copy of National Identification (ID Card, Passport)</li>
                                <li>Two (2) Letters of Recommendation</li>
                                <li>Proof of Address - Utility Bill OR Top section of Bank Statement (If the bill is not in your
                                    name, provide a Letter of Authorization from the homeowner, plus a copy of their ID,
                                    Passport, or Driver's Permit. Accepted utility bills include Cable, Electricity, Water,
                                    Phone (landlines), <strong>and</strong> on-premises Internet.)</li>
                            </ul>
                        </p>

                        <p><strong>You must complete the entire form for your application to be eligible (or considered) for
                                selection.</strong></p>
                    </div>

                    @if (session('submissionError'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('submissionError') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->isNotEmpty())
                        <div style="height: 200px; overflow-y:scroll;">
                            @foreach ($errors->messages() as $key => $error)
                                @php $error = $error[0]; @endphp
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <a href="#{{ $key }}">{{ $error }}</a>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>

                <section>
                    @php
                        $yesNoOptions = [['Yes', 'Yes'], ['No', 'No']];
                        // Reset question counter for this form
                        \App\View\Components\Form\QuestionNumbering::reset();
                    @endphp

                    <form action="{{ route('application.apply') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <x-form.section-h1 id="PersonalInfo">PERSONAL INFORMATION</x-form.section-h1>

                        {{-- NAME --}}
                        <x-form.column-3>
                            <x-slot name="col1">
                                <x-form.text-input id="APL_FName" label="First Name" value="{{ old('APL_FName') }}" />
                            </x-slot>
                            <x-slot name="col2">
                                <x-form.text-input id="APL_MName" label="Middle Name" :questionNumber="false" :required="false" />
                            </x-slot>
                            <x-slot name="col3">
                                <x-form.text-input id="APL_LName" label="Last Name" :questionNumber="false" />
                            </x-slot>
                        </x-form.column-3>

                        {{-- ADDRESS --}}
                        <x-form.column-2>
                            <x-slot name="col1">
                                <x-form.text-input id="APL_Address_1" label="Address Line 1"
                                    placeholder="Street Number (#2 Elizabeth Street)" />
                            </x-slot>
                            <x-slot name="col2">
                                <x-form.text-input id="APL_Address_2" label="Address Line 2" :questionNumber="false"
                                    placeholder="Area (St. Clair)" />
                            </x-slot>
                        </x-form.column-2>

                        {{-- WHICH AREA DO YOU LIVE IN? --}}
                        <x-form.select id="APL_Address_3" label="Which area do you live in?" :options="[
                            ['Arima', 'Arima'],
                            ['Chaguanas/Caroni', 'Chaguanas/Caroni'],
                            ['Couva/Tabaquite/Talparo', 'Couva/Tabaquite/Talparo'],
                            ['Diego Martin/St George West', 'Diego Martin/St George West'],
                            ['Mayaro/Rio Claro', 'Mayaro/Rio Claro'],
                            ['Penal/Debe/Siparia/St Patrick East', 'Penal/Debe/Siparia/St Patrick East'],
                            ['Point Fortin/ St Patrick West', 'Point Fortin/ St Patrick West'],
                            ['Port of Spain/St George Central', 'Port of Spain/St George Central'],
                            ['Princes Town/Victoria East', 'Princes Town/Victoria East'],
                            ['San Fernando/Victoria West', 'San Fernando/Victoria West'],
                            ['San Juan/Laventille/St George East', 'San Juan/Laventille/St George East'],
                            ['Sangre Grande/St Andrew', 'Sangre Grande/St Andrew'],
                            ['Tobago', 'Tobago'],
                            ['Toco/St David', 'Toco/St David'],
                            ['Arouca/Tunapuna/Piarco', 'Arouca/Tunapuna/Piarco'],
                        ]" />

                        {{-- GENDER --}}
                        <x-form.radio id="APL_Gender" label="Gender" :options="[['Male', 'M'], ['Female', 'F']]" />

                        {{-- EMAIL ADDRESS --}}
                        <x-form.text-input id="APL_Email" label="Email Address" />

                        {{-- CONTACT NUMBER --}}
                        <x-form.text-input id="APL_PPhone" label="Contact Number" placeholder="868-123-4567" />


                        {{-- TERNATIVE CONTACT NUMBER --}}
                        <x-form.text-input id="APL_APhone" label="Alternative Contact Number" :required="false"
                            placeholder="868-123-4567" :questionNumber="false" />

                        {{-- DATE OF BIRTH --}}
                        <x-form.date-input id="APL_DOB" label="Date of Birth" />


                        {{-- I AM A NATIONAL OF TRINIDAD AND TOBAGO --}}
                        <x-form.radio id="APL_National" label="I am a national of Trinidad and Tobago" :options="$yesNoOptions" />

                        {{-- IDENTIFICATION --}}
                        <x-form.select id="APL_ID_TYP"
                            label="Please provide the number for one of the following forms of identification."
                            :options="[['National Identification Card', 'NID'], ['Passport', 'PP']]" />

                        <x-form.text-input id="APL_ID_Number" label="Identification Number" :placeholder="20261612005"
                            :questionNumber="false" />

                        {{-- BIRTH CERTIFICATE PIN NUMBER --}}
                        <x-form.text-input id="APL_Birth_Pin" label="Birth Certificate Pin Number" :placeholder="45845154484" />

                        <x-form.section-h1 id="EducationSkills">EDUCATION & SKILLS BACKGROUND</x-form.section-h1>

                        {{-- PLEASE INDICATE THE NUMBER OF CSEC PASSES YOU CURRENTLY HAVE  --}}
                        <x-form.select id="APL_CSEC_Passes"
                            label="Please indicate the number of CSEC passes you currently have." :options="[
                                ['Less than 2', 'Less than 2'],
                                ['2 or more', '2 or more'],
                                ['Less than 5', 'Less than 5'],
                                ['5 or more', '5 or more'],
                            ]" />

                        {{-- HIGHEST LEVEL OF EDUCATION (COMPLETED) --}}
                        <div x-data="{ education: '{{ old('APL_HLOE', '') }}' }">
                            <x-form.column-2>
                                <x-slot name="col1">
                                    <x-form.select id="APL_HLOE" label="Highest Level of Education (Completed)"
                                        :options="[
                                            ['Primary', 'Primary'],
                                            ['Secondary', 'Secondary'],
                                            ['Tertiary', 'Tertiary'],
                                            ['Technical/Vocational', 'Technical/Vocational'],
                                        ]" x-model="education" />
                                </x-slot>

                                <x-slot name="col2">
                                    <div x-show="education === 'Technical/Vocational'">
                                        <x-form.text-input id="APL_HLOE_Specify"
                                            label="If Technical/Vocational, please specify" :required="false"
                                            :questionNumber="false" />
                                    </div>
                                </x-slot>
                            </x-form.column-2>
                        </div>

                        {{-- Employment Status --}}
                        <div x-data="{ APL_Employment_Status: '{{ old('APL_Employment_Status', '') }}' }">
                            <x-form.radio id="APL_Employment_Status" label="Are you Employed/Self-Employed?"
                                :options="$yesNoOptions" x-model="APL_Employment_Status" />

                            <div x-show="APL_Employment_Status === 'Yes'" x-cloak class="mt-4">
                                <div x-data="{ APL_Employment_Type: '{{ old('APL_Employment_Type', '') }}' }">
                                    <x-form.text-input id="APL_Job_Title" name="APL_Job_Title"
                                        label="Job Title (if applicable)" :required="true" :questionNumber="false" />
                                    <x-form.radio id="APL_Employment_Type" label="Employment Type" :options="[
                                        ['Employed full time', 'Employed full-time'],
                                        ['Employed part time', 'Employed part-time'],
                                        ['Self-Employed (Business Owner)', 'Self-Employed'],
                                        ['Both Employed and Business Owner', 'Both Employed and Business Owner'],
                                        ['Student', 'Student'],
                                        ['Unemployed', 'Unemployed'],
                                    ]"
                                        :required="true" :questionNumber="false" x-model="APL_Employment_Type" />
                                </div>
                            </div>
                        </div>

                        {{-- WHICH FACILITY DO YOU PREFER TO ATTEND YOUR IN-PERSON TRAINING SESSIONS? --}}
                        <x-form.radio id="APL_Training_Session"
                            label="Which facility would you prefer to attend your in-person training sessions?"
                            :options="[
                                ['St. James Youth Development Centre', 'St. James Youth Development Centre'],
                                ['Los Bajos Youth Development Centre', 'Los Bajos Youth Development Centre'],
                                ['California Youth Devel    							opment Centre', 'California Youth Development Centre'],
                                ['National Racquet Centre, Tacarigua', 'National Racquet Centre, Tacarigua'],
                                ['Tobago (Location to be confirmed)', 'Tobago'],
                            ]" />

                        {{-- PLEASE INDICATE WHETHER YOU HOLD ANY CERTIFICATES OR DOCUMENTATION CONFIRMING VOLUNTEER INITIATIVE UNDERTAKE IN PREVIOUS YEARS --}}
                        <x-form.radio id="APL_Volunteer_Certification"
                            label="Please indicate whether you hold any certificates or documentation confirming volunteer initiatives undertaken in previous years"
                            :options="$yesNoOptions" />

                        <x-form.section-h1>PROGRAMME INTEREST</x-form.section-h1>

                        <x-form.radio id="APL_Specialization"
                            label="Programme Modules and Specialization Track Selection<br><br><span style='font-weight: 600 !important;'>The Civic Engagement Leadership Academy (CELA) Programme includes compulsory core modules that all participants must complete, in addition to <strong>one (1) specialization track</strong> selected based on your interests.</span><br><br><strong>Please select ONE (1) specialization track you are most interested in:</strong>"
                            :options="[
                                [
                                    'Civic Identity, Citizenship & National Values',
                                    'Civic Identity, Citizenship & National Values',
                                ],
                                [
                                    'Leadership Development, Personal Growth & Workforce Readiness',
                                    'Leadership Development, Personal Growth & Workforce Readiness',
                                ],
                                [
                                    'Community Development, Safety & Resilience',
                                    'Community Development, Safety & Resilience',
                                ],
                            ]" />

                        {{-- ARE YOU AVAILABLE TO ATTEND ALL SCHEDULED SESSIONS OF THE COURSE? --}}
                        <x-form.radio id="APL_Attendance"
                            label="Are you able to attend all scheduled sessions of the course?" :options="$yesNoOptions" />

                        {{-- I AM AVAILABLE TO PROVIDE UP TO A MAXIMUM OF 72 HOURS OF VOLUNTEER SERVICE --}}
                        <x-form.radio id="APL_Can_Volunteer"
                            label="Are you available to provide a minimum of 72 hours of volunteer service, to be completed within a period not exceeding three (3) months, following the successful completion of the programme’s training component?"
                            :options="$yesNoOptions" />

                        {{-- PLEASE OUTLINE YOUR EXPERIENCE IN VOLUNTEERISM --}}
                        <x-form.text-area id="APL_Experience" label="Please outline your experience in Volunteerism."
                            :required="true" />

                        {{-- MOTIVATION & EXPECTATIONS --}}
                        <x-form.text-area id="APL_Motivation_Expectations"
                            label="Motivation & Expectations - Briefly describe why you are interested in joining the National Service CELA Programme."
                            :required="true" />

                        <x-form.section-h1>FEEDBACK</x-form.section-h1>

                        {{-- FEEDBACK --}}
                        <div x-data="{ APL_Post_Training_Intent: '{{ old('APL_Post_Training_Intent', '') }}' }">
                            <x-form.column-2>
                                <x-slot name="col1">
                                    <x-form.select id="APL_Post_Training_Intent"
                                        label="After completing the National Service CELA Programme, do you intend to:"
                                        :options="[
                                            ['Seek employment in full-time or part-time', 'Seek employment'],
                                            [
                                                'Continue your academic career (University, Technical/Vocational training, short courses)',
                                                'Continue studies',
                                            ],
                                            [
                                                ' Start your own organization (Community-Based Organisation or Non-Governmental Organisation)',
                                                'Start organisation',
                                            ],
                                            ['Continue volunteering initiatives', 'Continue volunteering'],
                                            ['Other', 'Other'],
                                        ]" x-model="APL_Post_Training_Intent" />
                                </x-slot>

                                <x-slot name="col2">
                                    <div x-show="APL_Post_Training_Intent === 'Other'" x-cloak>
                                        <x-form.text-input id="APL_Post_Training_Other" label="If other, please specify"
                                            :required="false" :questionNumber="false" />
                                    </div>
                                </x-slot>
                            </x-form.column-2>
                        </div>

                        {{-- HOW CONFIDENT ARE YOU IN ACHIEVING YOUR ACADEMIC/PROFESSIONAL GOAL WITHIN THE NEXT 12 MONTHS? --}}
                        <x-form.radio id="APL_Volunteer_Confidence"
                            label="How confident are you in achieving your academic/professional goal within the next 12 months?"
                            :options="[
                                ['Very Confident', 'Very Confident'],
                                ['Confident', 'Confident'],
                                ['Not Confident', 'Not Confident'],
                                ['Unsure', 'Unsure'],
                            ]" />

                        {{-- CONSENT FOR LONG-TERM FOLLOW-UP --}}
                        <x-form.radio id="APL_Consent_Followup"
                            label="I consent to be contacted by the Ministry of Sport and Youth Affairs' Monitoring & Evaluation Unit up to two (2) years after programme completion for tracer studies."
                            :options="$yesNoOptions" />

                        {{-- HOW DID YOU FIND OUT ABOUT THE PROGRAMME? --}}
                        <div x-data="{ APL_How_Found_Programme: '{{ old('APL_How_Found_Programme', '') }}' }">
                            <x-form.column-2>
                                <x-slot name="col1">
                                    <x-form.select id="APL_How_Found_Programme"
                                        label="How did you find out about the programme?" :options="[
                                            ['Social Media', 'Social Media'],
                                            ['Television/Radio/Newspaper advertisements', 'TV/Radio/News'],
                                            ['Website', 'Website'],
                                            ['Friend or Family Member', 'Friend/Family'],
                                            ['Other', 'Other'],
                                        ]"
                                        x-model="APL_How_Found_Programme" />
                                </x-slot>


                                <x-slot name="col2">
                                    <div x-show="APL_How_Found_Programme === 'Other'" x-cloak>
                                        <x-form.text-input id="APL_How_Found_Other" label="If other, please specify"
                                            :required="false" :questionNumber="false" />
                                    </div>
                                </x-slot>
                            </x-form.column-2>
                        </div>


                        {{-- Would you like to subscribe to the ministry's mailing list --}}
                        <x-form.radio id="APL_Subscribe_Mailing"
                            label="Would you like to subscribe to the Ministry's mailing list for updates on upcoming projects and programmes?"
                            :options="$yesNoOptions" />

                        {{-- I agree to have my photographs or images used by the MSYA --}}
                        <x-form.radio id="APL_Photo_Consent"
                            label="I agree to have my photographs or images used by the MSYA for promotion of the National Service CELA Programme."
                            :options="$yesNoOptions" />

                        <x-form.section-h1>RECOMMENDER INFORMATION</x-form.section-h1>

                        {{-- PROFESSIONAL RECOMMENDER 1 --}}
                        <x-form.column-2>
                            <x-slot name="col1">
                                <x-form.text-input id="APL_Rec1_FName" label="First Name of Professional Recommender 1"
                                    value="{{ old('APL_Rec1_FName') }}" />
                            </x-slot>
                            <x-slot name="col2">
                                <x-form.text-input id="APL_Rec1_LName" label="Last Name of Professional Recommender 1"
                                    :questionNumber="false" />
                            </x-slot>
                        </x-form.column-2>

                        {{-- RECOMMENDER DESIGNATION --}}
                        <x-form.text-input id="APL_Rec1_Designation" label="Designation of Professional Recommender 1"
                            placeholder="868-123-4567" />

                        {{-- RECOMMENDER CONTACT NUMBER --}}
                        <x-form.text-input id="APL_Rec1_Phone" label="Contact Number of Professional Recommender 1"
                            placeholder="868-123-4567" />

                        {{-- PROFESSIONAL RECOMMENDER 2 --}}
                        <x-form.column-2>
                            <x-slot name="col1">
                                <x-form.text-input id="APL_Rec2_FName" label="First Name of Professional Recommender 2"
                                    value="{{ old('APL_Rec2_FName') }}" />
                            </x-slot>
                            <x-slot name="col2">
                                <x-form.text-input id="APL_Rec2_LName" label="Last Name of Professional Recommender 2"
                                    :questionNumber="false" />
                            </x-slot>
                        </x-form.column-2>

                        {{-- RECOMMENDER DESIGNATION --}}
                        <x-form.text-input id="APL_Rec2_Designation" label="Designation of Professional Recommender 2"
                            placeholder="868-123-4567" />

                        {{-- RECOMMENDER CONTACT NUMBER --}}
                        <x-form.text-input id="APL_Rec2_Phone" label="Contact Number of Professional Recommender 2"
                            placeholder="868-123-4567" />


                        <x-form.section-h1>DOCUMENT UPLOADS</x-form.section-h1>

                        {{-- uired Documents --}}
                        <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />

                        <x-form.file-input id="File_National_ID"
                            label="National Identification Card or Trinidad and Tobago Passport" />

                        <x-form.file-input id="File_Proof_Address"
                            label="Proof of Address (Utility Bill or Top of Bank Statement)" />

                        <x-form.file-input id="File_Authorization_Letter" label="Letter of Authorization"
                            :required="false" />

                        <x-form.file-input id="File_Owner_ID" label="Owner’s ID" :required="false" />

                        <x-form.multi-file-input id="Files_Academic_Certificates"
                            label="Upload Your Academic Certificates Here. <span style='font-weight: 500 !important; color: #990000;'> (Multiple files are allowed)</span>" :required="false" />

                        <x-form.file-input id="File_Recommender_Statement_1" label="Recommender Statement 1" />

                        <x-form.file-input id="File_Recommender_Statement_2" label="Recommender Statement 2" />

                        <x-form.wrapper>
                            <h1 class="fw-bold text-center">NOTE</h1>
                            <hr>
                            <p style="text-align: justify;">
                                Participants must be willing to sign a Participation Agreement and to work to meet the
                                training programme's learning objectives and requirements. This form and the information
                                collected within are confidential and intended for use by the Ministry of Sport and Youth
                                Affairs. Your information will remain Private and Confidential and will not be used for
                                other purpose other than the above-mentioned.
                            </p>
                            <p style="text-align: justify;">
                                I hereby declare that the information given in this application is true and correct to the
                                best of my knowledge and belief. If any information provided in this application proves to
                                be false or incorrect, I accept the consequences of automatic rejection of the submission,
                                and I may be liable for any breach of the applicable laws of the Republic of Trinidad and
                                Tobago.
                            </p>
                        </x-form.wrapper>

                        <x-form.radio id="APL_Accepts" label="I have read and accept the above" :options="$yesNoOptions"
                            :questionNumber="false" />

                        <x-form.wrapper>
                            <div class="d-grid gap-2 col-3 mx-auto">
                                <input id="submit-button" type="submit" class="btn btn-success" style="" />
                            </div>
                        </x-form.wrapper>
                    </form>
                </section>
            </div>
        </div>

        <script>
            function calculateAge() {
                const dob = document.getElementById('APL_DOB').value;
                if (dob) {
                    const birthDate = new Date(dob);
                    const age = new Date().getFullYear() - birthDate.getFullYear();
                    const month = new Date().getMonth() - birthDate.getMonth();
                    if (month < 0 || (month === 0 && new Date().getDate() < birthDate.getDate())) {
                        age--;
                    }
                    document.getElementById('APL_Age').value = age;
                }
            }
        </script>
    </body>

@endsection
