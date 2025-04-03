@extends('Layouts.layout')
@section('Title', 'Application Form')
@section('Content')

    <body>
        <div id="application-form" class="container">
            <img src="https://apps.mydns.gov.tt/images/nltp_banner.jpg" alt="Banner" class="img-fluid min-width-100">
            <section>
                <div class="text-center">
                    <h1>NATIONAL LEADERSHIP PROGRAMME 2025</h1>
                    <h3>Application Form</h3>
                </div><br>
                <p>The Ministry of Youth Development and National Service, recognizes the need across all age groups and sectors, for shared responsibility, common values and positive experiences, as well as improvement within communities.  As such the Ministry creates opportunities for youth activists, non-profit organizations, youth-led and youth-serving organizations, as well as the national community to contribute to the National Service platform/agenda for Trinidad and Tobago.<br><br>

                    The Ministry envisages that National Service will allow citizens to connect with social issues, come together to accomplish common goals, help individuals develop different skills and increase volunteerism, which will ultimately address the unrealized social, educational and environmental needs of communities across Trinidad and Tobago.<br><br>
                    
                   This form is intended to collect information about potential registrants for the National Leadership Training Programme 2025. This training is facilitated by the Ministry of Youth Development and National Service (MYDNS) in collaboration with The University of the West Indies, St. Augustine Campus. The information collected will only be used for the registration, reporting and analysis of participants for this training programme. This form will take 10 minutes to complete. Thank you!</p>
    
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
                    ]
                @endphp
                <form action="{{ route('application.apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    <x-form.section-h1 id="Section1">Personal Information</x-form.section-h1>
    
                    <x-form.radio id="APL_Title" label="Title" :options="[ ['Mr.','Mr.'], ['Mrs.','Mrs.'], ['Ms.','Ms.'] ]" :selected="old('APL_Title')"/>
    
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.text-input id="APL_FName" label="First Name" value="{{ old('APL_FName') }}" />
                        </x-slot>
    
                        <x-slot name="col2">
                            <x-form.text-input id="APL_LName" label="Last Name" value="{{ old('APL_LName') }}" />
                        </x-slot>
                    </x-form.column-2>
    
                    <x-form.text-input id="APL_Address1" label="House/Apt number: eg # 123" value="{{ old('APL_Address1') }}" />
                    <x-form.text-input id="APL_Address2" label="Street/Road Name: eg London Street" value="{{ old('APL_Address2') }}" />
                    <x-form.text-input id="APL_Address3" label="City: eg Port-Of-Spain" value="{{ old('APL_Address3') }}" />
                    <x-form.select id="APL_Municipality" label="Municipality" :options="$areas" value="{{ old('APL_Municipality') }}"/>
    
                    <x-form.radio id="APL_Gender" label="Gender" :options="[ ['Male','M'], ['Female','F'] ]" :selected="old('APL_Gender')"/>
                    <x-form.date-input id="APL_DOB" label="Date of Birth" onchange="calculateAge()" value="{{ old('APL_DOB') }}"/>
    
                    {{-- <div class="col-md-6 mb-4">
                        <label for="APL_Age" class="form-label fw-bold">Age</label>
                        <input type="text" name="APL_Age" id="APL_Age" class="form-control" value="{{ old('APL_Age') }}" readonly>
                    </div> --}}
    
                    <x-form.text-input id="APL_PPhone" label="Primary Phone" value="{{ old('APL_PPhone') }}" />
                    <x-form.text-input id="APL_APhone" label="Alternate Phone" value="{{ old('APL_APhone') }}" :required="false" />
                    <x-form.text-input id="APL_Email" label="Email" value="{{ old('APL_Email') }}" />
    
                    <x-form.select id="APL_Marital" label="Marital Status" :options="[ ['Single', 'SS'], ['Married', 'MM'], ['Divorced', 'DD'], ['Widowed', 'WD'], ['Separated', 'SP'], ['Common Law', 'CL'] ]" value="{{ old('APL_Marital') }}"/>
    
                    <x-form.select id="APL_NID" label="Please choose one form of identification" :options="[ ['National Identification Card', 'NID'], ['Driver\'s Permit', 'DP'], ['Passport', 'PP'] ]" value="{{ old('APL_NID') }}" />
                    <x-form.text-input id="APL_NID_Number" label="Identification Number" value="{{ old('APL_NID_Number') }}" />
                    <x-form.text-input id="APL_BPN" label="Birth Certificate Pin Number" value="{{ old('APL_BPN') }}" />
    
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_HLOE" label="Highest Level of Education (Completed)" :options="[ ['Primary', 'PS'], ['Secondary', 'SS'], ['Tertiary', 'TL'], ['Technical/Vocational', 'TV'], ['Other', 'ZO'] ]" value="{{ old('APL_HLOE') }}" />
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_HLOE_Other" label="If other, please state" value="{{ old('APL_HLOE_Other') }}" :required="false"/>
                        </x-slot>
                    </x-form.column-2>
    
                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_Employment_Status" label="Which One Of The Following Best Describes Your Current Employment status?" :options="[ ['Self Employed','SE'], ['Under-Employed','UNE'], ['Unemployed','UE'], ['Student','STN'], ['Other','ZO'] ]" value="{{ old('APL_Employment_Status') }}"/>
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_Employment_Status_Other" label="If other, please state" value="{{ old('APL_Employment_Status_Other') }}" :required="false"/>
                        </x-slot>
                    </x-form.column-2>
    
                    <x-form.select id="APL_Field" label="What field are you employed in?" :options="[ ['Student','Student'], ['Accounting, Banking and Finance', 'Accounting, Banking and Finance'], ['Agriculture, Fishing and Farming', 'Agriculture, Fishing and Farming'], ['Architecture', 'Architecture'], ['Arts, Culture and Entertainment', 'Arts, Culture and Entertainment'], ['Business, Management and Administration', 'Business, Management and Administration'], ['Computers and Technology', 'Computers and Technology'], ['Construction', 'Construction'], ['Education and Training', 'Education and Training'], ['Engineering and Engineering Technologies', 'Engineering and Engineering Technologies'], ['Food Service', 'Food Service'], ['Government', 'Government'], ['Health and Medical', 'Health and Medical'], ['Hospitality, Travel and Tourism', 'Hospitality, Travel and Tourism'], ['Installation, Maintenance and Repair', 'Installation, Maintenance and Repair'], ['Legal, Criminal Justice and Law Enforcement', 'Legal, Criminal Justice and Law Enforcement'], ['Manufacturing and Production', 'Manufacturing and Production'], ['Marketing', 'Marketing'], ['Media, Communication and Broadcast', 'Media, Communication and Broadcast'], ['Social, Charity and Community Service', 'Social, Charity and Community Service'], ['Transportation and Distribution', 'Transportation and Distribution'], ['Other', 'Other'] ]" value="{{ old('APL_Field') }}"/>
    
                    <div x-data="{ APL_Accommodation: '{{ old('APL_Accommodation') }}' }">
                        <x-form.radio id="APL_Accommodation" label="Do you require any special accommodations?" :options="[['Yes', 'Yes'], ['No', 'No']]" x-model="APL_Accommodation" />
                        <div x-show="APL_Accommodation === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_Accommodation_Details" label="If yes, please state" value="{{ old('APL_Accommodation_Details') }}" required="true"/>
                        </div>
                    </div>
    
                    <x-form.text-input id="APL_Interest_Details" label="Briefly share details of your experience or interest in leadership training" value="{{ old('APL_Interest_Details') }}" />
    
                    <x-form.section-h1>Youth Group Information</x-form.section-h1>
    
                    <div x-data="{ APL_Youth_Group_Member: '{{ old('APL_Youth_Group_Member') }}' }">
                        <x-form.radio id="APL_Youth_Group_Member" label="Are you a member of a youth group or youth serving organization?" :options="[['Yes', 'Yes'], ['No', 'No']]" x-model="APL_Youth_Group_Member" />
                        <div x-show="APL_Youth_Group_Member === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_Organization_Name" label="What is the name of the organization?" value="{{ old('APL_Organization_Name') }}" required="true"/>
                            <x-form.text-input id="APL_Role" label="What is your position in the group/organization?" value="{{ old('APL_Role') }}" required="true"/>
                            <x-form.text-input id="APL_Membership_Length" label="How long have you been a member?" value="{{ old('APL_Membership_Length') }}" required="true"/>
                        </div>
                    </div>
    
                    <div>
                        <x-form.section-h1>Availability</x-form.form-section-heading>
                        <p class="text-center">Delivery Mode: Hybrid on Mondays, Tuesdays, and Wednesdays</p>
                    </div>
    
                    <x-form.radio id="APL_Availability_Virtual" label="Are you available to attend virtual training sessions?" :options="$yesNoOptions" value="{{ old('APL_Availability_Virtual') }}"/>
                    <x-form.radio id="APL_Availability_InPerson" label="Are you available to attend in-person training sessions?" :options="$yesNoOptions" value="{{ old('APL_Availability_InPerson') }}"/>
                    <x-form.radio id="APL_Internet" label="Do you have a reliable internet connection?" :options="$yesNoOptions" value="{{ old('APL_Internet') }}"/>
    
                    <div x-data="{ APL_Obligations: '{{ old('APL_Obligations') }}' }">
                        <x-form.radio id="APL_Obligations" label="Are there any obligations that may affect your successful completion of the programme?" :options="[ ['Yes', 'Yes'], ['No', 'No'] ]" x-model="APL_Obligations" />
                        <div x-show="APL_Obligations === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-area id="APL_Obligations_Details" label="If yes, please state" value="{{ old('APL_Obligations_Details') }}" required="true"/>
                        </div>
                    </div>
    
                    <div x-data="{ APL_MYDNS_Participant: '{{ old('APL_MYDNS_Participant') }}' }">
                        <x-form.radio id="APL_MYDNS_Participant" label="Have you participated in MYDNS Programmes in the last year?" :options="[['Yes', 'Yes'], ['No', 'No']]" x-model="APL_MYDNS_Participant" />
                        <div x-show="APL_MYDNS_Participant === 'Yes'" x-cloak class="mt-4">
                            <x-form.text-area id="APL_MYDNS_Participant_Details" label="If yes, please state" value="{{ old('APL_MYDNS_Participant_Details') }}" required="true"/>
                        </div>
                    </div>
    
                    <x-form.section-h1>Interest and Expectations</x-form.form-section-heading>
                        <x-form.text-area id="APL_NS_Interest" label="Do you have an interest in contributing through National Service or volunteer work?" value="{{ old('APL_NS_Interest') }}" required="true"/>
                    <x-form.text-area id="APL_Expectations" label="What do you expect to gain upon completion?" value="{{ old('APL_Expectations') }}" required="true"/>
    
                    <x-form.section-h1>Next of Kin</x-form.form-section-heading>
                    <x-form.text-input id="APL_NoK_Name" label="Next of Kin" value="{{ old('APL_NoK_Name') }}" required="true"/>
                    <x-form.text-input id="APL_NoK_Contact" label="Contact Number (Next of Kin)" value="{{ old('APL_NoK_Contact') }}" required="true"/>
    
                    <div>
                        <x-form.section-h1>Parent/Guardian</x-form.form-section-heading>
                        <p class="text-center">This section must be completed by a parent or guardian for all participants under 18.</p>
                    </div>
    
                    <x-form.text-input id="APL_PG_Name" label="Parent/Guardian Name" value="{{ old('APL_PG_Name') }}" :required="false"/>
                    <x-form.text-input id="APL_PG_Contact" label="Contact Number" value="{{ old('APL_PG_Contact') }}" :required="false"/>
    
                    <x-form.section-h1>Document Uploads</x-form.form-section-heading>
    
                    <div x-data="{ APL_COC_Choice: '{{ old('APL_COC_Choice') }}' }">
                        <x-form.radio id="APL_COC_Choice" label="Please select one to upload:" :options="[['Certificate of Character', 'COC'], ['Certificate of Character Receipt Number', 'CRN']]" x-model="APL_COC_Choice"/>
                        <div x-show="APL_COC_Choice === 'COC'" x-cloak class="mt-4">
                            <x-form.file-input id="File_Character_Certificate" label="Certificate of Character" />
                        </div>
                        <div x-show="APL_COC_Choice === 'CRN'" x-cloak class="mt-4">
                            <x-form.text-input id="APL_CRN" label="Input your Certificate of Character Receipt Number" value="{{ old('APL_CRN') }}" />
                        </div>
                    </div>
    
                    <x-form.file-input id="File_Recommender_Statement" label="Recommender Statement" />

                    <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />

                    <x-form.file-input id="File_National_ID" label="National ID" />

                    <x-form.multi-file-input id="Files_Academic_Certificates" label="Upload your academic certificates here (You may select multiple files)" />

                    <x-form.url-list id="Texts_Links" label="Insert any links that may support your application" />

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

                    {{-- <x-form.wrapper>
                        <div class="d-grid gap-2 col-3 mx-auto">
                            <button type="button" class="btn btn-success">Submit</button>
                        </div>
                    </x-form.wrapper> --}}
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
