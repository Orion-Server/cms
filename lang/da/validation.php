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

    'accepted' => 'Feltet :attribute skal accepteres.',
    'accepted_if' => 'Feltet :attribute skal accepteres, når :other er :value.',
    'active_url' => 'Feltet :attribute skal være en gyldig URL.',
    'after' => 'Feltet :attribute skal være en dato efter :date.',
    'after_or_equal' => 'Feltet :attribute skal være en dato efter eller lig med :date.',
    'alpha' => 'Feltet :attribute må kun indeholde bogstaver.',
    'alpha_dash' => 'Feltet :attribute må kun indeholde bogstaver, tal, bindestreger og understregninger.',
    'alpha_num' => 'Feltet :attribute må kun indeholde bogstaver og tal.',
    'array' => 'Feltet :attribute skal være en matrix.',
    'ascii' => 'Feltet :attribute må kun indeholde alfanumeriske tegn og symboler med en enkelt byte.',
    'before' => 'Feltet :attribute skal være en dato før :date.',
    'before_or_equal' => 'Feltet :attribute skal være en dato før eller lig med :date.',
    'between' => [
        'array' => 'Feltet :attribute skal indeholde mellem :min og :max elementer.',
        'file' => 'Feltet :attribute skal være mellem :min og :max kilobyte.',
        'numeric' => 'Feltet :attribute skal være mellem :min og :max.',
        'string' => 'Feltet :attribute skal være mellem :min og :max tegn.',
    ],
    'boolean' => 'Feltet :attribute skal være sandt eller falsk.',
    'confirmed' => 'Bekræftelsen af feltet :attribute stemmer ikke overens.',
    'current_password' => 'Adgangskoden er forkert.',
    'date' => 'Feltet :attribute skal være en gyldig dato.',
    'date_equals' => 'Feltet :attribute skal være en dato lig med :date.',
    'date_format' => 'Feltet :attribute skal matche formatet :format.',
    'decimal' => 'Feltet :attribute skal have :decimal decimaler.',
    'declined' => 'Feltet :attribute skal afvises.',
    'declined_if' => 'Feltet :attribute skal afvises, når :other er :value.',
    'different' => 'Feltet :attribute og :other skal være forskellige.',
    'digits' => 'Feltet :attribute skal være :digits cifre.',
    'digits_between' => 'Feltet :attribute skal være mellem :min og :max cifre.',
    'dimensions' => 'Feltet :attribute har ugyldige billeddimensioner.',
    'distinct' => 'Feltet :attribute har en duplikatværdi.',
    'doesnt_end_with' => 'Feltet :attribute må ikke slutte med følgende: :values.',
    'doesnt_start_with' => 'Feltet :attribute må ikke starte med følgende: :values.',
    'email' => 'Feltet :attribute skal være en gyldig email-adresse.',
    'ends_with' => 'Feltet :attribute skal ende med følgende: :values.',
    'enum' => 'Det valgte :attribute er ugyldigt.',
    'exists' => 'Det valgte :attribute er ugyldigt.',
    'file' => 'Feltet :attribute skal være en fil.',
    'filled' => 'Feltet :attribute skal have en værdi.',
    'gt' => [
        'array' => 'Feltet :attribute skal have flere end :value elementer.',
        'file' => 'Feltet :attribute skal være større end :value kilobyte.',
        'numeric' => 'Feltet :attribute skal være større end :value.',
        'string' => 'Feltet :attribute skal være længere end :value tegn.',
    ],
    'gte' => [
        'array' => 'Feltet :attribute skal have :value elementer eller mere.',
        'file' => 'Feltet :attribute skal være større end eller lig med :value kilobyte.',
        'numeric' => 'Feltet :attribute skal være større end eller lig med :value.',
        'string' => 'Feltet :attribute skal være længere end eller lig med :value tegn.',
    ],
    'image' => 'Feltet :attribute skal være et billede.',
    'in' => 'Det valgte :attribute er ugyldigt.',
    'in_array' => 'Feltet :attribute skal eksistere i :other.',
    'integer' => 'Feltet :attribute skal være et heltal.',
    'ip' => 'Feltet :attribute skal være en gyldig IP-adresse.',
    'ipv4' => 'Feltet :attribute skal være en gyldig IPv4-adresse.',
    'ipv6' => 'Feltet :attribute skal være en gyldig IPv6-adresse.',
    'json' => 'Feltet :attribute skal være en gyldig JSON-streng.',
    'lowercase' => 'Feltet :attribute skal være med små bogstaver.',
    'lt' => [
        'array' => 'Feltet :attribute skal have færre end :value elementer.',
        'file' => 'Feltet :attribute skal være mindre end :value kilobyte.',
        'numeric' => 'Feltet :attribute skal være mindre end :value.',
        'string' => 'Feltet :attribute skal være kortere end :value tegn.',
    ],
    'lte' => [
        'array' => 'Feltet :attribute må ikke have flere end :value elementer.',
        'file' => 'Feltet :attribute skal være mindre end eller lig med :value kilobyte.',
        'numeric' => 'Feltet :attribute skal være mindre end eller lig med :value.',
        'string' => 'Feltet :attribute skal være kortere end eller lig med :value tegn.',
    ],
    'mac_address' => 'Feltet :attribute skal være en gyldig MAC-adresse.',
    'max' => [
        'array' => 'Feltet :attribute må ikke have flere end :max elementer.',
        'file' => 'Feltet :attribute må ikke være større end :max kilobyte.',
        'numeric' => 'Feltet :attribute må ikke være større end :max.',
        'string' => 'Feltet :attribute må ikke være længere end :max tegn.',
    ],
    'max_digits' => 'Feltet :attribute må ikke have flere end :max cifre.',
    'mimes' => 'Feltet :attribute skal være en fil af typen: :values.',
    'mimetypes' => 'Feltet :attribute skal være en fil af typen: :values.',
    'min' => [
        'array' => 'Feltet :attribute skal have mindst :min elementer.',
        'file' => 'Feltet :attribute skal være mindst :min kilobyte.',
        'numeric' => 'Feltet :attribute skal være mindst :min.',
        'string' => 'Feltet :attribute skal være mindst :min tegn.',
    ],
    'min_digits' => 'Feltet :attribute skal have mindst :min cifre.',
    'missing' => 'Feltet :attribute skal være fraværende.',
    'missing_if' => 'Feltet :attribute skal være fraværende når :other er :value.',
    'missing_unless' => 'Feltet :attribute skal være fraværende medmindre :other er :value.',
    'missing_with' => 'Feltet :attribute skal være fraværende når :values er til stede.',
    'missing_with_all' => 'Feltet :attribute skal være fraværende når :values er til stede.',
    'multiple_of' => 'Feltet :attribute skal være et multiplum af :value.',
    'not_in' => 'Det valgte :attribute er ugyldigt.',
    'not_regex' => 'Formatet for feltet :attribute er ugyldigt.',
    'numeric' => 'Feltet :attribute skal være et tal.',
    'password' => [
        'letters' => 'Feltet :attribute skal indeholde mindst et bogstav.',
        'mixed' => 'Feltet :attribute skal indeholde mindst ét stort og ét lille bogstav.',
        'numbers' => 'Feltet :attribute skal indeholde mindst et tal.',
        'symbols' => 'Feltet :attribute skal indeholde mindst et symbol.',
        'uncompromised' => 'Den angivne :attribute er blevet offentliggjort i en databrud. Vælg venligst en anden :attribute.',
    ],
    'present' => 'Feltet :attribute skal være til stede.',
    'prohibited' => 'Feltet :attribute er forbudt.',
    'prohibited_if' => 'Feltet :attribute er forbudt når :other er :value.',
    'prohibited_unless' => 'Feltet :attribute er forbudt medmindre :other er i :values.',
    'prohibits' => 'Feltet :attribute forhindrer :other i at være til stede.',
    'regex' => 'Formatet for feltet :attribute er ugyldigt.',
    'required' => 'Feltet :attribute er påkrævet.',
    'required_array_keys' => 'Feltet :attribute skal indeholde indgange for: :values.',
    'required_if' => 'Feltet :attribute er påkrævet når :other er :value.',
    'required_if_accepted' => 'Feltet :attribute er påkrævet når :other er accepteret.',
    'required_unless' => 'Feltet :attribute er påkrævet medmindre :other er i :values.',
    'required_with' => 'Feltet :attribute er påkrævet når :values er til stede.',
    'required_with_all' => 'Feltet :attribute er påkrævet når :values er til stede.',
    'required_without' => 'Feltet :attribute er påkrævet når :values ikke er til stede.',
    'required_without_all' => 'Feltet :attribute er påkrævet når ingen af :values er til stede.',
    'same' => 'Feltet :attribute og :other skal matche.',
    'size' => [
        'array' => 'Feltet :attribute skal indeholde :size elementer.',
        'file' => 'Feltet :attribute skal være :size kilobyte.',
        'numeric' => 'Feltet :attribute skal være :size.',
        'string' => 'Feltet :attribute skal være :size tegn.',
    ],
    'starts_with' => 'Feltet :attribute skal starte med følgende: :values.',
    'string' => 'Feltet :attribute skal være en streng.',
    'timezone' => 'Feltet :attribute skal være en gyldig tidszone.',
    'unique' => 'Feltet :attribute er allerede taget.',
    'uploaded' => 'Feltet :attribute kunne ikke uploades.',
    'url' => 'Formatet for feltet :attribute er ugyldigt.',
    'uuid' => 'Feltet :attribute skal være en gyldig UUID.',

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

