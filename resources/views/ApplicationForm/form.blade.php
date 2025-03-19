@extends('Layouts.layout')
@section('Title', 'Application Form')
@section('Content')

    <body>       
        <div id="application-form" class="container">
            {{-- <img src="https://apps.mydns.gov.tt/images/rapp_banner.png" alt="Logo" class="img-fluid w-100"> --}}
            <section>
                <div class="text-center">
                    <h1>NATIONAL LEADERSHIP PROGRAMME 2025</h1>
                    <h3>Application Form</h3>
                </div>
                <p>DESCRIPTION</p>
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
                    
                    <x-form.column-3>
                        <x-slot name="col1">
                            <x-form.text-input id="APL_FName" label="First Name" />
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_MName" label="Middle Name" :required="false" />
                        </x-slot>
                        <x-slot name="col3">
                            <x-form.text-input id="APL_LName" label="Last Name" />
                        </x-slot>
                    </x-form.column-3>

                    <x-form.text-input id="APL_Address1" label="House/Apt number:eg # 123" />

                    <x-form.text-input id="APL_Address2" label="Street/Road Name: eg London Street" />

                    <x-form.text-input id="APL_Address3" label="City:eg Port-Of-Spain" />

                    <x-form.select id="APL_Municipality" label="Muncipality" :options="$areas"/>

                    <x-form.radio id="APL_Gender" label="Gender" :options="[
                        ['Male','M'],
                        ['Female','F'],
                    ]"/>

                    <x-form.date-input id="APL_DOB" label="Date of Birth" />

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

                    <x-form.section-h1>Proof of Nationality</x-form.section-h1>

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_NID" label="National ID (Please provide the number for ONE of your Trinidad and Tobago National ID)" :options="[
                                ['National Identification Card', 'NID'],
                                ['Driver\'s Permit', 'DP'],
                                ['Passport', 'PP'],
                            ]" />
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_NID_Number" label="Identification Number" />    
                        </x-slot>
                    </x-form.column-2>

                    <x-form.text-input id="APL_BPN" label="Birth Certificate Pin Number" />

                    <x-form.section-h1>Educational Information</x-form.section-h1>
                    
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
                    
                    <x-form.radio id="APL_Has_Minimum_OLevel_Passes" label="Do You Have A Minimum Of Two (2) O’ Level Passes?" :options="$yesNoOptions" />

                    <x-form.radio id="APL_Has_Technical_Qualifications" label="Do You Have Technical/Vocational Qualifications?" :options="$yesNoOptions" />

                    <x-form.radio id="APL_Has_Training" label="Do You Have Training or Experience In The Field Of Agriculture?" :options="$yesNoOptions" />

                    <x-form.radio id="APL_Is_Enrolled_In_Training" label="Are You Currently Enrolled In School Or Training Full Time?" :options="$yesNoOptions" />

                    <x-form.section-h1>Ministry Programmes</x-form.section-h1>
                    
                    <x-form.radio id="APL_Is_Enrolled_In_YAHP" label="Are you or any of your immediate family enrolled in any YOUTH IN AGRICULTURE Programmes?" :options="$yesNoOptions" />

                    <x-form.section-h1>Socio Economic Status</x-form.section-h1>
                    
                    <x-form.select id="APL_Income" label="Which One Of The Following Best Describes Your Monthly Household Income?" :options="[
                        ['Under 3000','1_U3K'],
                        ['3000-5000', '2_3-5'],
                        ['5001-7000', '3_5-7'],
                        ['7001-10,000', '4_7-10'],
                        ['10,001-15,000', '5_10-15'],
                        ['15,001 and above', '6_O15K'],
                    ]"/>

                    <x-form.radio id="APL_Has_Dependant" label="Do you have any Dependents (people who you are financially responsible for)?" :options="$yesNoOptions" />

                    <x-form.column-2>
                        <x-slot name="col1">
                        </x-slot>
                        <x-slot name="col2">
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

                    <x-form.select id="APL_Housing_Status" label="Which One Of The Following Best Describes Your Housing Arrangement?" :options="[
                        ['Rental','RT'],
                        ['Rent to own (HDC)','RTO'],
                        ['Mortgage','MG'],
                        ['I own my home','IMH'],
                        ['I do not own a home','IDMH'],
                    ]"/>

                    <x-form.select id="APL_Living_Status" label="Which One Of The Following Best Describes Your Living Arrangement?" :options="[
                        ['Living alone', 'LA'],
                        ['Living with your immediate family(parents, spouse, children)', 'LIF'],
                        ['Living with your adult children', 'LAC'],
                        ['Living with extended family (e.g., spouses parents, siblings, cousins)', 'LEF'],
                        ['Living with friends', 'LF'],
                        ['Living with a roommate(s)', 'LR'],
                    ]"/>
                    
                    <x-form.radio id="APL_Owns_Property" label="Do you own any land or property?" :options="$yesNoOptions" />
                    
                    <x-form.radio id="APL_Family_Owns_Land" label="Do You Or Any Of Your Immediate Family (Mother, Father, Sibling) Own Or Have A Lease Agreement For State Or Agriculture Land?" :options="$yesNoOptions" />

                    <x-form.section-h1>Agricultural Interest</x-form.section-h1>

                    <x-form.radio id="APL_Is_Interested" label="Are You Interested In Becoming A 21st Century Agro-Entrepreneur?" :options="$yesNoOptions" />

                    <x-form.text-input id="APL_Interest_Details" label="Please Give A Brief Description Of Your Interest Or Training In The Agriculture Sector (Include Both Formal Or Informal)." />

                    <x-form.text-input id="APL_Expectation" label="What Do You Expect To Gain Upon Completion Of The YAHP Programme?" />

                    <x-form.text-input id="APL_Justification" label="Please indicate why you think you should be selected as a participant of the Part Time YAHP Programme" />

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.radio id="APL_Has_Obligations" label="Are There Any Obligations that may affect your successful completion of this training?" :options="$yesNoOptions" />
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_Obligations_Details" label="If yes, please state" :required="false"/>
                        </x-slot>
                    </x-form.column-2>

                    <x-form.radio id="APL_Can_Attend" label="Will you be able to attend at least 85% of classes?" :options="$yesNoOptions" />

                    <x-form.radio id="APL_Is_First_Application" label="Is this your first time applying to this programme?" :options="$yesNoOptions" />

                    <x-form.column-2>
                        <x-slot name="col1">
                            <x-form.select id="APL_Source" label="How did you find out about the programme?" :options="[
                                ['Social Media','SM'],
                                ['Television/Radio/Newspaper advertisements','TRN'],
                                ['MYDNS Website','WS'],
                                ['Friend or Family member','FM'],
                                ['Other','OTH'],
                            ]"/>
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_Source_Other" label="If other, please state" :required="false"/>
                        </x-slot>
                    </x-form.column-2>

                    <x-form.section-h1>Emergency Contact Information</x-form.section-h1>

                    <x-form.text-input id="APL_Emergency_FName" label="Emergency Contact First Name" />
                    <x-form.text-input id="APL_Emergency_LName" label="Emergency Contact Last Name" />

                    <x-form.text-input id="APL_Emergency_Address1" label="House/Apt number:eg # 123" />
                    <x-form.text-input id="APL_Emergency_Address2" label="Street/Road Name: eg London Street" />
                    <x-form.text-input id="APL_Emergency_Address3" label="City:eg Port-Of-Spain" />

                    <x-form.text-input id="APL_Emergency_Phone" label="Contact Number" />

                    <x-form.text-input id="APL_Emergency_Relation" label="Relationship" />
                    
                    <x-form.section-h1>Recommender Information</x-form.section-h1>

                    <x-form.text-input id="APL_Recommender_FName" label="Recommender Contact First Name" />
                    <x-form.text-input id="APL_Recommender_LName" label="Recommender Contact Last Name" />

                    <x-form.text-input id="APL_Recommender_Address1" label="House/Apt number:eg # 123" />
                    <x-form.text-input id="APL_Recommender_Address2" label="Street/Road Name: eg London Street" />
                    <x-form.text-input id="APL_Recommender_Address3" label="City:eg Port-Of-Spain" />

                    <x-form.text-input id="APL_Recommender_Designation" label="Designation" />

                    <x-form.text-input id="APL_Recommender_Phone" label="Contact Number" />
                    
                    <x-form.section-h1>Additional</x-form.form-section-heading>
                    
                    <x-form.radio id="APL_Can_Use_Photo" label="Can the Ministry of Youth Development and National Service use your photograph and image for future videos, publications, brochures, websites and social media?" :options="$yesNoOptions" />

                    <x-form.radio id="APL_Can_Subscribe" label="Would you like to subscribe to the ministry's mailing list for updates on upcoming projects and programmes?" :options="$yesNoOptions" />

                    <x-form.section-h1>Document Uploads</x-form.form-section-heading>
                                        
                    <x-form.column2>
                        <x-slot name="col1">
                            <x-form.file-input id="File_Character_Certificate" label="Certificate of Character" />
                        </x-slot>
                        <x-slot name="col2">
                            <x-form.text-input id="APL_CRN" label="Alternatively, you may input your Certificate of Character Receipt Number" placeholder="Receipt Number" :required="false" />
                        </x-slot>
                    </x-form.column2>
                        
                    <x-form.file-input id="File_Recommender_Statement" label="Recommender Statement" />
                    
                    <x-form.file-input id="File_Birth_Certificate" label="Birth Certificate" />

                    <x-form.file-input id="File_National_ID" label="National ID" />

                    <x-form.multi-file-input id="Files_Academic_Certificates" label="Upload your academic certificates here (You may select multiple files)" />

                    <x-form.multi-text-input id="Texts_Links" label="Insert any links that may support your application" placeholder="http://example.com" count=2 :required="false" />

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
                        <button type="submit">Submit</button>
                    </x-form.wrapper>
                </form>
            </section>
        </div>
    </body>