<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'APL_Accepts' => [
            'regex' => 'The Participation Agreement field must be accepted',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'APL_FName' => 'First Name',
        'APL_MName' => 'Middle Name',
        'APL_LName' => 'Last Name',
        'APL_Title' => 'Title',
        'APL_Address1' => 'Address 1',
        'APL_Address2' => 'Address 2',
        'APL_Address3' => 'Address 3',
        'APL_Municipality' => 'Municipality',
        'APL_Gender' => 'Gender',
        'APL_DOB' => 'Date of Birth',
        'APL_PPhone' => 'Primary Phone',
        'APL_APhone' => 'Alternative Phone',
        'APL_Email' => 'Email Address',
        'APL_Marital' => 'Marital Status',
        'APL_NID' => 'National ID',
        'APL_NID_Number' => 'National ID Number',
        'APL_BPN' => 'Birth Paper Number',
        'APL_HLOE' => 'Highest Level of Education',
        'APL_HLOE_Other' => 'Highest Level of Education Other',
        'APL_Has_Minimum_OLevel_Passes' => 'Has Minimum OLevel Passes',
        'APL_Has_Technical_Qualifications' => 'Has Technical Qualifications',
        'APL_Has_Training' => 'Has Training',
        'APL_Is_Enrolled_In_Training' => 'Is Enrolled In Training',
        'APL_Is_Enrolled_In_YAHP' => 'Is Enrolled In YAHP',
        'APL_Income' => 'Income',
        'APL_Has_Dependant' => 'Has Dependant',
        'APL_Employment_Status' => 'Employment Status',
        'APL_Employment_Status_Other' => 'Employment Status Other',
        'APL_Housing_Status' => 'Housing Status',
        'APL_Living_Status' => 'Living Status',
        'APL_Owns_Property' => 'Owns Property',
        'APL_Family_Owns_Land' => 'Family Owns Land',
        'APL_Is_Interested' => 'Is Interested',
        'APL_Interest_Details' => 'Interest Details',
        'APL_Expectation' => 'Expectation',
        'APL_Justification' => 'Justification',
        'APL_Has_Obligations' => 'Has Obligations',
        'APL_Obligations_Details' => 'Obligations Details',
        'APL_Can_Attend' => 'Can Attend',
        'APL_Is_First_Application' => 'Is First Application',
        'APL_Source' => 'Source',
        'APL_Source_Other' => 'Source Other',
        'APL_Emergency_FName' => 'Emergency Contact First Name',
        'APL_Emergency_LName' => 'Emergency Contact Last Name',
        'APL_Emergency_Address1' => 'Emergency Contact Address 1',
        'APL_Emergency_Address2' => 'Emergency Contact Address 2',
        'APL_Emergency_Address3' => 'Emergency Contact Address 3',
        'APL_Emergency_Phone' => 'Emergency Contact Phone',
        'APL_Emergency_Relation' => 'Emergency Contact Relation',
        'APL_Recommender_FName' => 'Recommender First Name',
        'APL_Recommender_LName' => 'Recommender Last Name',
        'APL_Recommender_Address1' => 'Recommender Address 1',
        'APL_Recommender_Address2' => 'Recommender Address 2',
        'APL_Recommender_Address3' => 'Recommender Address 3',
        'APL_Recommender_Designation' => 'Recommender Designation',
        'APL_Recommender_Phone' => 'Recommender Phone',
        'APL_Can_Use_Photo' => 'Can Use Photo',
        'APL_Can_Subscribe' => 'Can Subscribe',
        'APL_Accepts' => 'Participation Agreement',
    ],

];
