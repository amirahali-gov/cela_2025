@extends('Layouts.layout')
@section('Title', 'Application Form')
@section('Content')

    <body>
        <div id="application-form" class="container">
            {{-- <img src="https://apps.mydns.gov.tt/images/rapp_participant_banner.jpg" alt="Logo" class="img-fluid w-100"> --}}
            <section>
                <div class="text-center">
                    <h1>NATIONAL LEADERSHIP PROGRAMME 2025</h1>
                    <h3>Application Form</h3>
                </div><br>
                <p>This form is intended to collect information about potential registrants for
                   the National Leadership Training Programme 2024. This training is facilitated
                   by the Ministry of Youth Development and National Service (MYDNS) in
                   collaboration with The University of the West Indies, St. Augustine Campus.
                   The information collected will only be used for the registration, reporting and
                   analysis of participants for this training programme. This form will take 10
                   minutes to complete. Thank you!</p>
                @if(session('submissionError'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session('submissionError') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <script>
                        console.error("{{session('submissionError')}}");
                    </script>
                @endif
                @if ($errors->isNotEmpty())
                    <div style="height: 200px; overflow-y:scroll;">
                        @foreach ($errors->messages() as $key => $error)
                            @php $error = $error[0]; @endphp {{-- We only need the first validation error per field --}}
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <a href="#{{$key}}">{{$error}}</a>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <script>
                                console.error("{{$error}}");
                            </script>
                        @endforeach
                    </div>
                @endif
            </section>
            <section>
                @php
                    $yesNoOptions = [
                        ['Yes','Y'],
                        ['No','N'],
                    ]
                @endphp
                <form action="{{ route('application.apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <x-form.section-h1 id="Section1">Personal Information</x-form.section-h1>

                    <x-form.radio id="APL_Title" label="Title" :options="[
                        ['Mr.','Mr.'],
                        ['Mrs.','Mrs.'],
                        ['Ms.','Ms.']
                    ]"/>

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.text-input id="APL_FName" label="First Name" />
                        </x-slot>

                        <x-slot name="col2">
                            <x-form.text-input id="APL_LName" label="Last Name" />
                        </x-slot>
                    </x-form.column-2>

                    <x-form.text-input id="APL_Address1" label="House/Apt number:eg # 123" />

                    <x-form.text-input id="APL_Address2" label="Street/Road Name: eg London Street" />

                    <x-form.text-input id="APL_Address3" label="City:eg Port-Of-Spain" />

                    <x-form.select id="APL_Municipality" label="Muncipality" :options="$areas"/>

                    <x-form.radio id="APL_Gender" label="Gender" :options="[
                        ['Male','M'],
                        ['Female','F'],
                    ]"/>

                    <x-form.date-input id="APL_DOB" label="Date of Birth" />

                    <div class="col-md-6 mb-4">
                        <!-- Age Input (Read-only) -->
                        <label for="APL_Age" class="form-label fw-bold">Age</label>
                        <input type="text" id="APL_Age" class="form-control" readonly>
                    </div>

                    <x-form.text-input id="APL_PPhone" label="Primary Phone" />

                    <x-form.text-input id="APL_APhone" label="Alternate Phone" :required="false" />

                    <x-form.text-input id="APL_Email" label="Email" />

                    <x-form.select id="APL_Marital" label="Marital Status" :options="[
                        ['Single', 'SS'],
                        ['Married', 'MM'],
                        ['Divorced', 'DD'],
                        ['Widowed', 'WD'],
                        ['Separated', 'SP'],
                        ['Common Law', 'CL'],
                    ]"/>



                    <x-form.select id="APL_NID" label="Please choose one form of identification" :options="[
                                ['National Identification Card', 'NID'],
                                ['Driver\'s Permit', 'DP'],
                                ['Passport', 'PP'],
                            ]" />

                    <x-form.text-input id="APL_NID_Number" label="Identification Number" />

                    <x-form.text-input id="APL_BPN" label="Birth Certificate Pin Number" />

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_HLOE" label="Highest Level of Education (Completed)" :options="[
                                ['Primary', 'PS'],
                                ['Secondary', 'SS'],
                                ['Tertiary', 'TL'],
                                ['Technical/Vocational', 'TV'],
                                ['Other', 'ZO'],
                            ]"/>

                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_HLOE_Other" label="If other, please state"  :required="false"/>
                        </x-slot>
                    </x-form.column-2>

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_Employment_Status" label="Which One Of The Following Best Describes Your Current Employment status?" :options="[
                                ['Self Employed','SE'],
                                ['Under-Employed','UNE'],
                                ['Unemployed','UE'],
                                ['Student','STN'],
                                ['Other','ZO'],
                            ]"/>
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_Employment_Status_Other" label="If other, please state" :required="false"/>
                        </x-slot>
                    </x-form.column-2>

                    <x-form.select id="APL_Field" label="What field are you employed in? (NB: If you selected unemployed in the previous question, you are not required to answer this question)" :options="[
                        ['Student','Student'],
                        ['Accounting, Banking and Finance', 'Accounting, Banking and Finance'],
                        ['Agriculture, Fishing and Farming', 'Agriculture, Fishing and Farming'],
                        ['Architecture', 'Architecture'],
                        ['Arts, Culture and Entertainment,', 'Arts, Culture and Entertainment'],
                        [' Business, Management and Administration', ' Business, Management and Administration'],
                        [' Computers and Technology', ' Computers and Technology'],
                        [' Construction', ' Construction'],
                        [' Education and Training', ' Education and Training'],
                        [' Engineering and Engineering Technologies', ' Engineering and Engineering Technologies'],
                        ['Food Service', 'Food Service'],
                        ['Government', 'Government'],
                        ['Health and Medical', 'Health and Medical'],
                        ['Hospitality, Travel and Tourism', 'Hospitality, Travel and Tourism'],
                        ['Installation, Maintenance and Repair', 'Installation, Maintenance and Repair'],
                        ['Legal, Criminal Justice and Law Enforcement', ' Legal, Criminal Justice and Law Enforcement'],
                        ['Manufacturing and Production', 'Manufacturing and Production'],
                        ['Marketing', 'Marketing'],
                        ['Media, Communication and Broadcast', 'Media, Communication and Broadcast'],
                        [' Social, Charity and Community Service', ' Social, Charity and Community Service'],
                        ['Transportation and Distribution', 'Transportation and Distribution'],
                        ['Other', 'Other']
                    ]"/>

                    {{-- Alpine conditional rendering --}}
                    <div x-data="{ APL_Accommodation: '' }">

                        <x-form.radio
                            id="APL_Accommodation"
                            label="Do you require any special accommodations?"
                            :options="[['Yes', 'Yes'], ['No', 'No']]"
                            x-model="APL_Accommodation"
                        />

                        <!-- Conditional Text Input (Visible when 'Yes' is selected) -->
                        <div x-show="APL_Accommodation === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_Accommodation_Details" label="If yes, please state" :required="true"/>
                        </div>
                    </div>

                    <x-form.text-input id="APL_Interest_Details" label="Briefly share details of your experience or interest in leadership training" />

                    <x-form.section-h1>Youth Group Information</x-form.section-h1>

                    <div x-data="{ APL_Youth_Group_Member: '' }">

                        <x-form.radio
                            id="APL_Youth_Group_Member"
                            label="Are you a member of a youth group or youth serving organization?"
                            :options="[['Yes', 'Yes'], ['No', 'No']]"
                            x-model="APL_Youth_Group_Member"
                        />

                        <!-- Conditional Text Input (Visible when 'Yes' is selected) -->
                        <div x-show="APL_Youth_Group_Member === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_Organization_Name" label="What is the name of the organization?" :required="true"/>
                            <x-form.text-input id="APL_Role" label="What is your position in the group/organization?" :required="true"/>
                            <x-form.text-input id="APL_Membership_Length" label="How long have you been a member of this group/organization?" :required="true"/>
                        </div>
                    </div>

                    <div>
                        <x-form.section-h1>Availability</x-form.form-section-heading>
                        <p class="text-center">Delivery Mode: Hybrid on Mondays, Tuesdays and Wednesdays</p>
                    </div>

                    <x-form.radio id="APL_Availability_Virtual" label="Are you available to attend virtual training sessions - Mondays to Wednesdays from 6:00pm to 8:00 pm?" :options="$yesNoOptions" />
                    <x-form.radio id="APL_Availability_InPerson" label="Are you available to attend in-person training sessions (one session per Module) from 5:30 pm to 7:00 pm?" :options="$yesNoOptions" />
                    <x-form.radio id="APL_Internet" label="Do you have a reliable internet connection?" :options="$yesNoOptions" />


                    <div x-data="{ APL_Obligations: '' }">
                        <x-form.radio
                            id="APL_Obligations"
                            label="Are there any obligations that may affect your successful completion of the programme?"
                            :options="[ ['Yes', 'Yes'], ['No', 'No'] ]"
                            x-model="APL_Obligations"
                        />

                        <!-- Conditional Text Input (Visible when 'Yes' is selected) -->
                        <div x-show="APL_Obligations === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-area id="APL_Obligations_Details" label="If yes, please state" :required="true"/>
                        </div>
                    </div>

                    <div x-data="{ APL_MYDNS_Participant: '' }">
                        <x-form.radio
                            id="APL_MYDNS_Participant"
                            label=" Have you participated in any of the Ministry of Youth Development and National Service (MYDNS) Programmes or any programme sponsored by the MYDNS within the last two (2) years??"
                            :options="[['Yes', 'Yes'], ['No', 'No']]"
                            x-model="APL_MYDNS_Participant"
                        />

                        <!-- Conditional Text Input (Visible when 'Yes' is selected) -->
                        <div x-show="APL_MYDNS_Participant === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-area id="APL_MYDNS_Participant_Details" label="If yes, please state" :required="true"/>
                        </div>
                    </div>

                    <x-form.section-h1>Training Expectations</x-form.form-section-heading>
                    <x-form.text-area id="APL_Expectations" label="What do you expect to gain upon completion of this programme?" :required="true"/>


                    <x-form.section-h1>Next of Kin</x-form.form-section-heading>

                    <x-form.text-input id="APL_NoK_Name" label="Next of Kin" :required="true"/>

                    <x-form.text-input id="APL_NoK_Contact" label="Contact Number (Next of Kin)" :required="true"/>

                    <div>
                        <x-form.section-h1>Parent/Guardian</x-form.form-section-heading>
                        <p class="text-center"> This section must be completed by a parent or guardian for all participants that are under 18.</p>
                    </div>

                    <x-form.text-input id="APL_PG_Name" label="Parent/Guardian Name" :required="false"/>

                    <x-form.text-input id="APL_PG_Contact" label="Contact Number" :required="false"/>

                    <x-form.section-h1>Document Uploads</x-form.form-section-heading>


                    <div x-data="{ APL_COC_Choice: '' }">

                        <x-form.radio
                            id="APL_COC_Choice"
                            label="Please select one of the following to upload:"
                            :options="[['Certificate of Character', 'COC'], ['Certificate of Character Receipt Number', 'CRN']]"
                            x-model="APL_COC_Choice"
                        />

                        <div x-show="APL_COC_Choice === 'COC'" x-cloak class="mt-4">
                            <x-form.file-input id="File_Character_Certificate" label="Certificate of Character" />
                        </div>

                        <div x-show="APL_COC_Choice === 'CRN'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_CRN" label="Input your Certificate of Character Receipt Number" placeholder="Receipt Number" :required="false" />
                        </div>
                    </div>

                    <x-form.file-input id="File_Recommender_Statement" label="Recommender Statement" />

                    <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />

                    <x-form.file-input id="File_National_ID" label="National ID" />

                    <x-form.multi-file-input id="Files_Academic_Certificates" label="Upload your academic certificates here (You may select multiple files)" />

                    <x-form.url-list id="urlInput" label="Insert any links that may support your application" />

                    <x-form.wrapper>
                        <h3 class="fw-bold">Participation Agreement</h3>
                        <hr>
                        <p>
                            Participants must be willing to sign a participation agreement and work to meet the learning objectives and requirements of the training. This form and information collected within it is confidential and intended for use by the Ministry of Youth Development and National Services.
                            Your information will remain private and confidential and will not be used for other purposes other than the above mentioned.
                        </p>
                        <p>
                            I hereby declare that the information given in this application is true and correct to the best of my knowledge and belief. If any information given in this application proves to be false or incorrect, I accept the consequence of the automatic rejection of the submission.
                        </p>
                    </x-form.wrapper>


                    <x-form.radio id="APL_Accepts" label="I have read and accept the above" :options="$yesNoOptions" />

                    <x-form.wrapper>
                        <div class="d-grid gap-2 col-3 mx-auto">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </x-form.wrapper>
                </form>
            </section>
        </div>

    </body>
