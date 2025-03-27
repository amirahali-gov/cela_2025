
{{--

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

                    <x-form.radio id="APL_Can_Subscribe" label="Would you like to subscribe to the ministry's mailing list for updates on upcoming projects and programmes?" :options="$yesNoOptions" /> --}}


