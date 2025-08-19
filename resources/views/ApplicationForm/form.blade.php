@extends('Layouts.layout')
@section('Title', 'Application Form')
@section('Content')

<body>
    <div id="application-form" class="container-fluid">
        {{-- <img src="https://apps.mydns.gov.tt/images/rapp_participant_banner.jpg" alt="Logo" class="img-fluid w-100"> --}}
        <section>
            <div class="text-center">
                <h1>GERIATRIC ADOLESCENT PARTNERSHIP PROGRAMME</h1>
                <h3>G.A.P.P.</h3>
            </div><br>
            <p>A call for application for caregivers to join the Geriatric Adolescent Partnership Programme (GAPP). Requirements:
            <ul>
                <li>18-35 years</li>
                <li>Possess minimum of two (2) CSEC passes</li>
                <li>National of Trinidad and Tobago</li>
                <li>Certificate in Geriatric Care or Professional Healthcare</li>
                <li>The applicant must be available to provide service/care for a period of 6 months (following successful completion of training).</li>
            </ul>

            Applicants must submit the following documents when applying:
            <ul>
                <li>Copy of Academic and/or skills training Certificates</li>
                <li>Copy of National Identification (ID Card, Passport, Birth Certificate)</li>
                <li>Certificate of Character or Receipt from the TTPS</li>
                <li>(Two) 2 Letters of Recommendation</li>
                <li>Copy of National Insurance card (optional)</li>
                <li>Proof of Address - Utility Bill OR Top section of Bank Statement (If not in your name, letter of authorization is required with copy of owner's ID)</li>
            </ul>

            You must complete the entire form for your application to be eligible (or considered) for selection.
            </p>
            @if(session('submissionError'))
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
                    <a href="#{{$key}}">{{$error}}</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endforeach
            </div>
            @endif
        </section>

        <section>
            @php
            $yesNoOptions = [
            ['Yes','Y'],
            ['No','N'],
            ];
            // Reset question counter for this form
            \App\View\Components\Form\QuestionNumbering::reset();
            @endphp

            <form action="{{ route('application.apply') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-form.section-h1 id="PersonalInfo">Personal Information</x-form.section-h1>

                {{-- 1. NAME --}}
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

                {{-- 2. ADDRESS --}}
                <x-form.column-2>
                    <x-slot name="col1">
                        <x-form.text-input id="APL_Address_1" label="Address Line 1" />
                    </x-slot>
                    <x-slot name="col2">
                        <x-form.text-input id="APL_Address_2" label="Address Line 2" :questionNumber="false" />
                    </x-slot>
                </x-form.column-2>

                {{-- 3. WHICH AREA DO YOU LIVE IN? --}}
                <x-form.select id="APL_Area" label="Which area do you live in?" :options="[
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
                        ['Tunapuna/Piarco', 'Tunapuna/Piarco'],
                    ]" />

                {{-- 4. GENDER --}}
                <x-form.radio id="APL_Gender" label="Gender" :options="[
                        ['Male','M'],
                        ['Female','F'],
                    ]" />

                {{-- 5. DATE OF BIRTH --}}
                <x-form.date-input id="APL_DOB" label="Date of Birth" />

                {{-- 6. AGE (Auto-calculated) --}}
                {{-- <div class="mb-4">
                        <label for="APL_Age" class="form-label fw-bold">Age (Auto-calculated)</label>
                        <input type="text" id="APL_Age" class="form-control" readonly>
                    </div> --}}

                {{-- 7. EDUCATION & SKILLS BACKGROUND --}}
                <x-form.section-h1 id="EducationSkills">Education & Skills Background</x-form.section-h1>

                <div x-data="{ education: '{{ old('APL_HLOE', '') }}' }">
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select
                                id="APL_HLOE"
                                label="Highest Level of Education (Completed)"
                                :options="[
                                        ['Primary', 'Primary'],
                                        ['Secondary', 'Secondary'],
                                        ['Tertiary', 'Tertiary'],
                                        ['Technical/Vocational', 'Technical/Vocational'],
                                    ]"
                                xModel="education" />
                        </x-slot>

                        <x-slot name="col2">
                            <div x-show="education === 'Technical/Vocational'">
                                <x-form.text-input
                                    id="APL_HLOE_Specify"
                                    label="If Technical/Vocational, please specify"
                                    :required="false"
                                    :questionNumber="false" />
                            </div>
                        </x-slot>
                    </x-form.column-2>
                </div>

                {{-- 8. Employment Status --}}
                <x-form.radio id="APL_Employment_Status" label="Are you employed/self-employed?" :options="$yesNoOptions" />

                <div x-data="{ APL_Employment_Status: '' }">
                    <div x-show="APL_Employment_Status == 'Y'" x-cloak class="mt-4">
                        <x-form.text-input id="APL_Job_Title" label="Job Title (if applicable)" :required="false" :questionNumber="false" />
                        <x-form.radio id="APL_Employment_Type" label="Employment Type" :options="[
                                ['Full-time', 'Full-time'],
                                ['Part-time', 'Part-time'],
                                ['Self-employed (Business owner)', 'Self-employed'],
                                ['Both Employed and Business Owner', 'Both'],
                            ]" :required="false" :questionNumber="false" />
                    </div>
                </div>

                {{-- 9. CONTACT NUMBER --}}
                <x-form.text-input id="APL_PPhone" label="Contact Number" />

                {{-- 10. ALTERNATIVE CONTACT NUMBER --}}
                <x-form.text-input id="APL_APhone" label="Alternative Contact Number" :required="false" />

                {{-- 11. EMAIL ADDRESS --}}
                <x-form.text-input id="APL_Email" label="Email Address" />

                {{-- 12. IDENTIFICATION --}}
                <x-form.select id="APL_ID_TYP" label="Please provide the number for one of the following forms of identification" :options="[
                        ['National Identification Card', 'NID'],
                        ['Passport', 'PP'],
                    ]" />

                <x-form.text-input id="APL_ID_Number" label="Identification Number" :questionNumber="false" />

                {{-- 13. BIRTH CERTIFICATE PIN NUMBER --}}
                <x-form.text-input id="APL_BIRTH_PIN" label="Birth Certificate Pin Number" />

                {{-- 14. DO YOU HAVE A NATIONAL INSURANCE NUMBER (NIS)? --}}
                <div x-data="{ APL_Has_NIS: '' }">
                    <x-form.radio id="APL_Has_NIS" label="Do you have a National Insurance Number (NIS)?" :options="$yesNoOptions" />

                    <div x-show="APL_Has_NIS == 'Y'" x-cloak class="mt-4">
                        <x-form.text-input id="APL_NIS_Number" label="Please enter your National Insurance Number (NIS)" :required="false" :questionNumber="false" />
                    </div>
                </div>

                {{-- 15. DO YOU HAVE A BANK ACCOUNT? --}}
                <x-form.radio id="APL_Has_Bank_Account" label="Do you have a bank account?" :options="$yesNoOptions" />

                {{-- 16. WHAT IS YOUR PREFERRED REGION FOR PLACEMENT? --}}
                <x-form.select id="APL_Preferred_Region" label="What is your preferred region for placement?" :options="[
                        ['Northern Region (Curepe to Carenage)', 'Northern'],
                        ['St Patrick Region (Icacos to Penal)', 'St Patrick'],
                        ['Victoria (San Fernando to Princess Town)', 'Victoria'],
                        ['North East (St Augustine to Arima)', 'North East'],
                        ['East (Cumuto to Rio Claro)', 'East'],
                        ['Central (Caroni/Chaguanas/Couva to Claxton Bay)', 'Central'],
                    ]" />

                {{-- 17. I AM A NATIONAL OF TRINIDAD AND TOBAGO --}}
                <x-form.radio id="APL_TT" label="I am a national of Trinidad and Tobago" :options="$yesNoOptions" />

                {{-- 18. I POSSESS TWO CSEC PASSES OR MORE --}}
                <x-form.radio id="APL_2_CXC_Passes" label="I possess two CSEC passes or more" :options="$yesNoOptions" />

                {{-- 19. I POSSESS A CERTIFICATE REFLECTING COMPETENCIES IN GERIATRIC CARE OR PROFESSIONAL HEALTHCARE --}}
                <x-form.radio id="APL_Geriatric_Certif" label="I possess a certificate reflecting competencies in Geriatric Care or Professional Healthcare" :options="$yesNoOptions" />

                {{-- 20. FROM WHICH INSTITUTION DID YOU RECEIVE YOUR CERTIFICATION? --}}
                <x-form.text-input id="APL_Certification_Institution" label="From which institution did you receive your certification?" />

                <x-form.section-h1>Programme Interest</x-form.section-h1>

                {{-- 21. I AM AVAILABLE TO PROVIDE GERIATRIC CARE BETWEEN THE HOURS 8:00 AM - 4:00 PM MONDAYS TO FRIDAYS --}}
                <x-form.radio id="APL_Available_Weekdays" label="I am available to provide geriatric care between the hours 8:00 AM - 4:00 PM Mondays to Fridays (except public holidays) if successful" :options="$yesNoOptions" />

                {{-- 22. PLEASE OUTLINE YOUR EXPERIENCE IN PROVIDING GERIATRIC CARE SERVICES --}}
                <x-form.text-area id="APL_Experience" label="Please outline your experience in providing geriatric care services" :required="true" />

                {{-- 23. MOTIVATION & EXPECTATIONS --}}
                <x-form.text-area id="APL_Motivation_Expectations" label="Motivation & Expectations - Briefly describe why you are interested in joining the National Service GAPP Programme" :required="true" />

                <x-form.section-h1>Feedback</x-form.section-h1>

                {{-- 24. POST-TRAINING INSTRUCTIONS --}}
                <div x-data="{ APL_Post_Training_Intent: '{{ old('APL_Post_Training_Intent', '') }}' }">
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select 
                                id="APL_Post_Training_Intent" 
                                label="After completing the National Service GAPP 6 months Programme, do you intend to:" 
                                :options="[
                                    ['Seek employment in geriatric care', 'Seek employment'],
                                    ['Continue studies in healthcare', 'Continue studies'],
                                    ['Start your own caregiving business', 'Start business'],
                                    ['Other', 'Other'],
                                ]"
                                x-model="APL_Post_Training_Intent"
                            />
                        </x-slot>

                        <x-slot name="col2">
                            <div x-show="APL_Post_Training_Intent === 'Other'" x-cloak>
                                <x-form.text-input 
                                    id="APL_Post_Training_Other" 
                                    label="If other, please specify" 
                                    :required="false" 
                                    :questionNumber="false" 
                                />
                            </div>
                        </x-slot>
                    </x-form.column-2>
                </div>

                {{-- 25. CONSENT FOR LONG-TERM FOLLOW-UP --}}
                <x-form.radio id="APL_Consent_Followup" label="I consent to be contacted by the Ministry of Sport and Youth Affairs' Monitoring & Evaluation Unit up to two (2) years after programme completion for tracer studies" :options="$yesNoOptions" />

                {{-- 26. HOW DID YOU FIND OUT ABOUT THE PROGRAMME? --}}
                <div x-data="{ APL_How_Found_Programme: '{{ old('APL_How_Found_Programme', '') }}' }">
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select 
                                id="APL_How_Found_Programme" 
                                label="How did you find out about the programme?" 
                                :options="[
                                    ['Social Media', 'Social Media'],
                                    ['Television/Radio/Newspaper advertisements', 'TV/Radio/News'],
                                    ['Website', 'Website'],
                                    ['Friend or Family Member', 'Friend/Family'],
                                    ['Other', 'Other'],
                                ]"
                                x-model="APL_How_Found_Programme"
                            />
                        </x-slot>

                        <x-slot name="col2">
                            <div x-show="APL_How_Found_Programme === 'Other'" x-cloak>
                                <x-form.text-input 
                                    id="APL_How_Found_Other" 
                                    label="If other, please specify" 
                                    :required="false" 
                                    :questionNumber="false" 
                                />
                            </div>
                        </x-slot>
                    </x-form.column-2>
                </div>


                {{-- 27. Would you like to subscribe to the ministry's mailing list --}}
                <x-form.radio id="APL_Subscribe_Mailing" label="Would you like to subscribe to the ministry's mailing list for updates on upcoming projects and programmes?" :options="$yesNoOptions" />

                {{-- 28. I agree to have my photographs or images used by the MSYA --}}
                <x-form.radio id="APL_Photo_Consent" label="I agree to have my photographs or images used by the MSYA for promotion of the National Service GAPP Programme" :options="$yesNoOptions" />

                <x-form.section-h1>Recommender Information</x-form.section-h1>

                {{-- 29-31. PROFESSIONAL RECOMMENDER 1 --}}
                <x-form.column-2>
                    <x-slot name="col1">
                        <x-form.text-input id="APL_Prof_Rec_FName" label="First Name of Professional Recommender 1" />
                    </x-slot>
                    <x-slot name="col2">
                        <x-form.text-input id="APL_Prof_Rec_LName" label="Last Name of Professional Recommender 1" :questionNumber="false" />
                    </x-slot>
                </x-form.column-2>
                <x-form.text-input id="APL_Prof_Rec_Designation" label="Designation of Professional Recommender 1" />
                <x-form.text-input id="APL_Prof_Rec_Phone" label="Contact Number of Professional Recommender 1" />

                {{-- 32-34. PROFESSIONAL RECOMMENDER 2 --}}
                 <x-form.column-2>
                    <x-slot name="col1">
                        <x-form.text-input id="APL_Prof_Rec_2_FName" label="First Name of Professional Recommender 2" />
                    </x-slot>
                    <x-slot name="col2">
                        <x-form.text-input id="APL_Prof_Rec_2_LName" label="Last Name of Professional Recommender 2" :questionNumber="false" />
                    </x-slot>
                </x-form.column-2>
                <x-form.text-input id="APL_Prof_Rec_2_Designation" label="Designation of Professional Recommender 2" />
                <x-form.text-input id="APL_Prof_Rec_2_Phone" label="Contact Number of Professional Recommender 2" />

                <x-form.section-h1>Document Uploads</x-form.section-h1>

                {{-- Required Documents --}}
                <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />
                <x-form.file-input id="File_National_ID" label="National ID / Passport" />
                <x-form.radio id="APL_Character_Selection" label="Please select either certificate of character or the receipt" :options="[
                    ['Certificate', 'Certificate of Character'],
                    ['Receipt', 'Certificate Of Character Receipt Number']
                ]" />
                <x-form.text-input id="APL_CRN" label="Certificate of Character Receipt Number" :required="false" :questionNumber="false" />
                <x-form.file-input id="File_Character_Certificate" label="Certificate of Character (or Receipt from TTPS)" :questionNumber="false" :required="false" />
                <x-form.file-input id="File_Recommender_Statement_1" label="Letter of Recommendation 1" />
                <x-form.file-input id="File_Recommender_Statement_2" label="Letter of Recommendation 2" />

                <x-form.multi-file-input id="Files_Academic_Certificates" label="Academic and/or Skills Training Certificates" :required="false"/>
                <x-form.file-input id="File_Geriatric_Certificate" label="Certificate in Geriatric Care or Professional Healthcare" :required="false"/>
                {{-- Optional Documents --}}
                <x-form.file-input id="File_NIS_Card" label="National Insurance Card (Optional)" :required="false" />
                <x-form.file-input id="File_Proof_Address" label="Proof of Address (Utility Bill or Bank Statement)" />
                <x-form.file-input id="File_Authorization_Letter" label="Authorization Letter (if proof of address not in your name)" :required="false" />
                <x-form.file-input id="File_Owner_ID" label="Copy of Owner's ID (if using authorization letter)" :required="false" />


                <x-form.wrapper>
                    <h3 class="fw-bold text-center">NOTE</h3>
                    <hr>
                    <p class="text-justify">
                        Participants must be willing to sign a participation agreement and work to meet the learning objectives and requirements of the training. This form and information collected within is confidential and intended for use by the Ministry of Sport and Youth Affairs.
                        Your information will remain private and confidential and will not be used for other purposes other than the above mentioned.
                    </p>
                    <p class="text-justify">
                        I hereby declare that the information given in this application is true and correct to the best of my knowledge and belief. If any information given in this application proves to be false or incorrect, I accept the consequences of automatic rejection of the submission.
                    </p>
                </x-form.wrapper>

                <x-form.radio id="APL_Accepts" label="I have read and accept the above" :options="$yesNoOptions" />

                <x-form.wrapper>
                    <div class="d-grid gap-2 col-3 mx-auto">
                        <input type="submit" class="btn btn-success" />
                    </div>
                </x-form.wrapper>
            </form>
        </section>
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