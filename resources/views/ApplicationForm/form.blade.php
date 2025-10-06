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
                                                                                                <h1>Creative Faces</h1>
                                                                                                <h2>“Youth Empowerment Through Makeup Artistry”</h2>
                                                                                            </div><br>

                                                                                            <div>
                                                                                                <p class="text-justify">The <strong>Ministry of Sport and Youth Affairs</strong>, in partnership with <strong>Sacha Cosmetics Ltd.</strong>,
                                                                                                    invites young people to join a <strong>two-day introductory workshop in Makeup Artistry</strong>—a creative,
                                                                                                    hands-on experience focused on developing new skills and
                                                                                                    confidence under professional mentorship. Participants must bring a <strong>freestanding tabletop mirror</strong>
                                                                                                    for use during the
                                                                                                    training.</p>
                                                                                            </div>

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
        ['Yes', 'Y'],
        ['No', 'N'],
    ];
    // Reset question counter for this form
    \App\View\Components\Form\QuestionNumbering::reset();
                                                                                            @endphp

                                                                                            <form action="{{ route('application.apply') }}" method="POST" enctype="multipart/form-data">
                                                                                                @csrf

                                                                                                <x-form.radio id="APL_Will_Bring_Mirror" label="I agree to bring my own freestanding mirror to participate in this training" :questionNumber="false"
                                                                                                    :options="$yesNoOptions" />

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
                                                                                                        <x-form.text-input id="APL_Address_1" label="Address Line 1" placeholder="Street Number (#2 Elizabeth Street)" />
                                                                                                    </x-slot>
                                                                                                    <x-slot name="col2">
                                                                                                        <x-form.text-input id="APL_Address_2" label="Address Line 2" :questionNumber="false" placeholder="Area (St. Clair)" />
                                                                                                    </x-slot>
                                                                                                </x-form.column-2>



                                                                                                {{-- 3. GENDER --}}
                                                                                                <x-form.radio id="APL_Gender" label="Gender" :options="[
            ['Male', 'M'],
            ['Female', 'F'],
        ]" />

                                                                                                {{-- 4. EMAIL ADDRESS --}}
                                                                                                <x-form.text-input id="APL_Email" label="Email Address" />

                                                                                                {{-- 5. CONTACT NUMBER --}}
                                                                                                <x-form.text-input id="APL_PPhone" label="Contact Number" placeholder="868-123-4567" />


                                                                                                {{-- 6. ALTERNATIVE CONTACT NUMBER --}}
                                                                                                <x-form.text-input id="APL_APhone" label="Alternative Contact Number" :required="false" placeholder="868-123-4567" />

                                                                                                {{-- 7. DATE OF BIRTH --}}
                                                                                                <x-form.date-input id="APL_DOB" label="Date of Birth" />

                                                                                                {{-- . AGE (Auto-calculated) --}}
                                                                                                {{-- <div class="mb-4">
                                                                                                        <label for="APL_Age" class="form-label fw-bold">Age (Auto-calculated)</label>
                                                                                                        <input type="text" id="APL_Age" class="form-control" readonly>
                                                                                                    </div> --}}

                                                                                                {{-- 8. REGION/WHICH AREA DO YOU LIVE IN? --}}
                                                                                                <div x-data="{ APL_Address_3: '{{ old('APL_Address_3', '') }}', APL_Address_3_Other: '{{ old('APL_Address_3_Other', '') }}' }">
                                                                                                    <x-form.select id="APL_Address_3" label="Which area do you live in?" :options="[
            ['Arima', 'Arima'],
            ['Chaguanas', 'Chaguanas'],
            ['Couva/Tabaquite/Talparo', 'Couva/Tabaquite/Talparo'],
            ['Diego Martin', 'Diego Martin'],
            ['Penal/Debe', 'Penal/Debe'],
            ['Point Fortin', 'Point Fortin'],
            ['Port of Spain City', 'Port of Spain City'],
            ['Princes Town', 'Princes Town'],
            ['Mayaro/Rio Claro', 'Mayaro/Rio Claro'],
            ['San Fernando City', 'San Fernando City'],
            ['San Juan/Laventille', 'San Juan/Laventille'],
            ['Sangre Grande', 'Sangre Grande'],
            ['Siparia', 'Siparia'],
            ['Tunapuna/Piarco', 'Tunapuna/Piarco'],
            ['Other', 'Other'],
        ]" x-model="APL_Address_3" />

                                                                                                    <div x-show="APL_Address_3 === 'Other'" x-cloak>
                                                                                                        <x-form.text-input id="APL_Address_3_Other" label="If other, please specify" :required="false" :questionNumber="false" x-model="APL_Address_3_Other" />
                                                                                                    </div>
                                                                                                </div>


                                                                                                {{-- 9. NATIONALITY --}}
                                                                                                <x-form.text-input id="APL_Nationality" label="Nationality" placeholder="" />

                                                                                                {{-- 10. IDENTIFICATION --}}
                                                                                                <x-form.select id="APL_ID_TYP" label="Please provide one form of identification." :options="[
            ['National Identification Card', 'NID'],
            ['Passport', 'PP'],
        ]" />
                                                                                                <x-form.text-input id="APL_ID_Number" label="Identification Number" :questionNumber="false" />

                                                                                                {{-- 11. BIRTH CERTIFICATE PIN NUMBER --}}
                                                                                                <x-form.text-input id="APL_BIRTH_PIN" label="Birth Certificate Pin Number" />

                                                                                                {{-- Required Documents --}}
                                                                                                <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />

                                                                                                <x-form.file-input id="File_National_ID" label="National Identification Card or Trinidad and Tobago Passport" />


                                                                                                {{-- 12. EDUCATION & SKILLS BACKGROUND --}}
                                                                                                <x-form.section-h1 id="EducationSkills">Education & Skills Background</x-form.section-h1>

                                                                                                <div 
                                                                                                    x-data="{ 
                                                                                                        education: '{{ old('APL_HLOE', '') }}',
                                                                                                        levels: {
                                                                                                            'Primary': 1,
                                                                                                            'Secondary': 2,
                                                                                                            'Tertiary': 3,
                                                                                                            'Technical/Vocational': 3
                                                                                                        }
                                                                                                    }"
                                                                                                >
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
                                                                                                                x-model="education" />
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

                                                                                                    <div x-show="levels[education] > 1">
                                                                                                        <x-form.number-input 
                                                                                                            id="APL_CSEC_Passes" 
                                                                                                            label="Number of CSEC Passes" 
                                                                                                            placeholder=""
                                                                                                            :questionNumber="false" />
                                                                                                    </div>
                                                                                                </div>

                                                                                                {{-- 13. Employment Status --}}
                                                                                                {{-- Changes required fields from false to true --}}
                                                                                                <x-form.radio id="APL_Employment_Type" label="Employment Status" :options="[
            ['Employed full time', 'Employed full time'],
            ['Employed part time', 'Employed part time'],
            ['Self-Employed (Business Owner)', 'Self-Employed'],
            ['Both Employed and Business Owner', 'Both'],
            ['Student', 'Student'],
            ['Unemployed', 'Unemployed'],
        ]" :required="true" :questionNumber="true" x-model="APL_Employment_Type" />

                                                                                                {{-- 14. PROGRAMME INTEREST --}}
                                                                                                <x-form.section-h1 id="ProgrammeInterest">Programme Interest</x-form.section-h1>
                                                                                            <div class="mb-4 w-full">
                                                                                                <p><strong>This course will be delivered in 3 cohorts, Tuesday and Thursdays from 3:00pm to 6:00pm.</strong></p>
                                                                                                <table class="table table-responsive w-full min-w-full border-collapse border border-gray-300">
                                                                                                    <thead>
                                                                                                        <tr class="bg-gray-100">
                                                                                                            <th class="border border-gray-300 px-2 sm:px-4 py-2 text-left font-semibold text-sm sm:text-base">Cohort</th>
                                                                                                            <th class="border border-gray-300 px-2 sm:px-4 py-2 text-left font-semibold text-sm sm:text-base">Date</th>
                                                                                                            <th class="border border-gray-300 px-2 sm:px-4 py-2 text-left font-semibold text-sm sm:text-base">Time</th>
                                                                                                            <th class="border border-gray-300 px-2 sm:px-4 py-2 text-left font-semibold text-sm sm:text-base">Venue</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">1</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">Tuesday 14th October &<br>Thursday 16th October 2025</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">3:00pm – 6:00pm</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">Los Bajos Youth Development Centre</td>
                                                                                                        </tr>
                                                                                                        <tr class="bg-gray-50">
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">2</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">Wednesday 15th October &<br>Wednesday 22nd October 2025</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">3:00pm – 6:00pm</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">St James Youth Development Centre</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">3</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">Tuesday 21st October &<br>Thursday 23rd October 2025</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">3:00pm – 6:00pm</td>
                                                                                                            <td class="border border-gray-300 px-2 sm:px-4 py-2 text-sm sm:text-base">California Youth Development Centre</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>

                                                                                                <x-form.radio id="APL_Programme" label="I am interested in attending this course:" :options="[
            ['Cohort 1: Tuesday 14th and Thursday 16th October 2025 at Los Bajos Youth Development Centre', 'Cohort 1 - Los Bajos'],
            ['Cohort 2: Wednesday 15th October & Wednesday 22nd October 2025 at St James Youth Development Centre', 'Cohort 2 - St James'],
            ['Cohort 3: Tuesday 21st and Thursday 23rd October 2025 at California Youth Development Centre', 'Cohort 3 - California'],
        ]" :required="true" :questionNumber="true" />

                                                                                                {{-- 15. Are you able to attend all scheduled sessions of the course? --}}
                                                                                                <div x-data="{ APL_Attend: '{{ old('APL_Attend', '') }}' }">
                                                                                                    <x-form.radio 
                                                                                                        id="APL_Attend"
                                                                                                        label="Are you able to attend all scheduled sessions of the course?"
                                                                                                        :options="$yesNoOptions" 
                                                                                                    />

                                                                                                    <div x-show="APL_Attend === 'N'" x-cloak>
                                                                                                        <x-form.text-input 
                                                                                                            id="APL_Attend_Explanation" 
                                                                                                            label="If no, please explain" 
                                                                                                            :questionNumber="false"
                                                                                                        />
                                                                                                    </div>
                                                                                                </div>

                                                                                                {{-- 16. Do you have any experience in make up? --}}
                                                                                                <div x-data="{ 
                                                                                                    APL_Experience: '{{ old('APL_Experience', '') }}',
                                                                                                    experience_years: '{{ old('APL_Num_Experience_Years', '') }}'
                                                                                                }">
                                                                                                    <x-form.radio 
                                                                                                        id="APL_Experience"
                                                                                                        label="Do you have any experience in make up?"
                                                                                                        :options="$yesNoOptions" 
                                                                                                    />

                                                                                                    <div x-show="APL_Experience === 'Y'" x-cloak>
                                                                                                        <x-form.select id="APL_Num_Experience_Years" label="How long have you been practicing?" :options="[
            ['Less than 1 year', 'Less than 1 year'],
            ['1-2 years', '1-2 years'],
            ['2-3 years', '2-3 years'],
            ['3-4 years', '3-4 years'],
            ['4-5 years', '4-5 years'],
            ['5+ years', '5+ years'],
        ]" x-model="experience_years" :questionNumber="false" />
                                                                                                    </div>

                                                                                                    <div x-show="APL_Experience === 'Y'" x-cloak>
                                                                                                        <x-form.text-area 
                                                                                                            id="APL_Experience_Details" 
                                                                                                            label="If yes, provide details." 
                                                                                                            :questionNumber="false"
                                                                                                        />
                                                                                                    </div>
                                                                                                </div>

                                                                                                {{-- How do you see this course contribution to your future plans? --}}
                                                                                                <x-form.text-area id="APL_Future_Plans" label="How do you see this course contribution to your future plans?"/>

                                                                                                {{-- 18. How did you find out about the programme? --}}
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

                                                                                                {{-- 17. Consent to Service Terms and Conditions --}}
                                                                                                <x-form.section-h1 id="TermsAndConditions">Consent to Service Terms and Conditions</x-form.section-h1>

                                                                                                <x-form.radio id="APL_Contact_Consent" label="I consent to be contacted by the Ministry of Sport and Youth Affairs Monitoring & Evaluation Unit up to two (2) years after programme completion for tracer studies." :options="$yesNoOptions" />

                                                                                                {{-- 19. Would you like to subscribe to the Ministry's mailing list for updates on upcoming projects and programmes?  --}}
                                                                                                <x-form.radio id="APL_Subscribe" label="Would you like to subscribe to the Ministry's mailing list for updates on upcoming projects and programmes?" :options="$yesNoOptions" />

                                                                                                {{-- 20. I agree to have my photographs or images used by the MSYA for promotion on all media pages.  --}}
                                                                                                <x-form.radio id="APL_Photo_Consent" label="I agree to have my photographs or images used by the MSYA for promotion on all media pages." :options="$yesNoOptions" />

                                                                                                <x-form.wrapper>
                                                                                                    <h1 class="fw-bold text-center">NOTE</h1>
                                                                                                    <hr>
                                                                                                    <p class="text-justify">
                                                                                                        I hereby declare that the information given in this application is true and correct to the best of my knowledge and belief. If any information given in this application proves to be false or incorrect, I accept the consequences of automatic rejection of the submission and that I may be liable for any breach of the applicable Laws of the Republic of Trinidad and Tobago.
                                                                                                    </p>

                                                                                                </x-form.wrapper>

                                                                                                <x-form.radio id="APL_Accepts" label="I have read and accept the above" :questionNumber="false" :options="$yesNoOptions" />

                                                                                                <x-form.wrapper>
                                                                                                    <div class="d-grid gap-2 col-3 mx-auto">
                                                                                                        <!-- <input type="submit" class="btn btn-success" style="border-radius: 1.5rem; height: 3rem; background-color: #3b6573;" /> -->
                                                                                                        <input type="submit" class="btn btn-success" style="border-radius: 1.5rem; height: 3rem; background-color: #3b6573;" value="Submit"/>
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