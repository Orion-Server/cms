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

    'accepted' => ':Attribute-kenttä on hyväksyttävä.',
    'accepted_if' => ':Attribute-kentän on oltava hyväksytty, kun :other on :value.',
    'active_url' => ':Attribute-kentän on oltava validi URL-osoite.',
    'after' => ':Attribute-kentän on oltava päivämäärä :date jälkeen.',
    'after_or_equal' => ':Attribute-kentän on oltava päivämäärä :date jälkeen tai sama kuin se.',
    'alpha' => ':Attribute-kenttä saa sisältää vain kirjaimia.',
    'alpha_dash' => ':Attribute-kenttä saa sisältää vain kirjaimia, numeroita, viivoja ja alaviivoja.',
    'alpha_num' => ':Attribute-kenttä saa sisältää vain kirjaimia ja numeroita.',
    'array' => ':Attribute-kentän on oltava taulukko.',
    'ascii' => ':Attribute-kenttä saa sisältää vain yksibyteisiä aakkosnumeerisia merkkejä ja symboleja.',
    'before' => ':Attribute-kentän on oltava päivämäärä ennen :date.',
    'before_or_equal' => ':Attribute-kentän on oltava päivämäärä ennen tai sama kuin :date.',
    'between' => [
        'array' => ':Attribute-kentän on oltava :min - :max kohdan taulukko.',
        'file' => ':Attribute-kentän on oltava :min - :max kilotavun kokoinen tiedosto.',
        'numeric' => ':Attribute-kentän on oltava :min - :max välillä.',
        'string' => ':Attribute-kentän on oltava :min - :max merkin pituinen.',
    ],
    'boolean' => ':Attribute-kentän on oltava tosi tai epätosi.',
    'confirmed' => ':Attribute-kentän vahvistus ei täsmää.',
    'current_password' => 'Salasana on virheellinen.',
    'date' => ':Attribute-kenttä ei ole kelvollinen päivämäärä.',
    'date_equals' => ':Attribute-kentän on oltava päivämäärä :date.',
    'date_format' => ':Attribute-kentän on oltava muodossa :format.',
    'decimal' => ':Attribute-kentän on oltava :decimal desimaalipaikkaa.',
    'declined' => ':Attribute-kentän on oltava hylätty.',
    'declined_if' => ':Attribute-kentän on oltava hylätty, kun :other on :value.',
    'different' => ':Attribute-kentän on oltava erilainen kuin :other.',
    'digits' => ':Attribute-kentän on oltava :digits numeroa.',
    'digits_between' => ':Attribute-kentän on oltava :min - :max numeron pituinen.',
    'dimensions' => ':Attribute-kentällä on virheelliset kuvan mitat.',
    'distinct' => ':Attribute-kentällä on kaksoiskappaleita.',
    'doesnt_end_with' => ':Attribute-kenttä ei saa päättyä seuraaviin: :values.',
    'doesnt_start_with' => ':Attribute-kenttä ei saa alkaa seuraavilla: :values.',
    'email' => ':Attribute-kentän on oltava validi sähköpostiosoite.',
    'ends_with' => ':Attribute-kentän on päätyttävä seuraaviin: :values.',
    'enum' => 'Valittu :attribute on virheellinen.',
    'exists' => 'Valittu :attribute on virheellinen.',
    'file' => ':Attribute-kentän on oltava tiedosto.',
    'filled' => ':Attribute-kentällä on oltava arvo.',
    'gt' => [
        'array' => ':Attribute-kentällä on oltava enemmän kuin :value kohdetta.',
        'file' => ':Attribute-kentän koon on oltava suurempi kuin :value kilotavua.',
        'numeric' => ':Attribute-kentän on oltava suurempi kuin :value.',
        'string' => ':Attribute-kentän merkkijonon on oltava pidempi kuin :value merkkiä.',
    ],
    'gte' => [
        'array' => ':Attribute-kentällä on oltava :value kohdetta tai enemmän.',
        'file' => ':Attribute-kentän koon on oltava suurempi tai yhtä suuri kuin :value kilotavua.',
        'numeric' => ':Attribute-kentän on oltava suurempi tai yhtä suuri kuin :value.',
        'string' => ':Attribute-kentän merkkijonon on oltava pidempi tai yhtä pitkä kuin :value merkkiä.',
    ],
    'image' => ':Attribute-kentän on oltava kuva.',
    'in' => 'Valittu :attribute on virheellinen.',
    'in_array' => ':Attribute-kentän on oltava arvo :other.',
    'integer' => ':Attribute-kentän on oltava kokonaisluku.',
    'ip' => ':Attribute-kentän on oltava validi IP-osoite.',
    'ipv4' => ':Attribute-kentän on oltava validi IPv4-osoite.',
    'ipv6' => ':Attribute-kentän on oltava validi IPv6-osoite.',
    'json' => ':Attribute-kentän on oltava validi JSON-merkkijono.',
    'lowercase' => ':Attribute-kentän on oltava pienaakkosia.',
    'lt' => [
        'array' => ':Attribute-kentällä on oltava vähemmän kuin :value kohdetta.',
        'file' => ':Attribute-kentän koon on oltava pienempi kuin :value kilotavua.',
        'numeric' => ':Attribute-kentän on oltava pienempi kuin :value.',
        'string' => ':Attribute-kentän merkkijonon on oltava lyhyempi kuin :value merkkiä.',
    ],
    'lte' => [
        'array' => ':Attribute-kentällä ei saa olla enemmän kuin :value kohdetta.',
        'file' => ':Attribute-kentän koon on oltava pienempi tai yhtä suuri kuin :value kilotavua.',
        'numeric' => ':Attribute-kentän on oltava pienempi tai yhtä suuri kuin :value.',
        'string' => ':Attribute-kentän merkkijonon on oltava lyhyempi tai yhtä pitkä kuin :value merkkiä.',
    ],
    'mac_address' => ':Attribute-kentän on oltava validi MAC-osoite.',
    'max' => [
        'array' => ':Attribute-kentällä ei saa olla enempää kuin :max kohdetta.',
        'file' => ':Attribute-kentän koon on oltava enintään :max kilotavua.',
        'numeric' => ':Attribute-kentän on oltava enintään :max.',
        'string' => ':Attribute-kentän merkkijonon on oltava enintään :max merkkiä.',
    ],
    'max_digits' => ':Attribute-kentän numerossa ei saa olla enempää kuin :max numeroa.',
    'mimes' => ':Attribute-kentän tiedostotyypin on oltava: :values.',
    'mimetypes' => ':Attribute-kentän tiedostotyypin on oltava: :values.',
    'min' => [
        'array' => ':Attribute-kentällä on oltava vähintään :min kohdetta.',
        'file' => ':Attribute-kentän koon on oltava vähintään :min kilotavua.',
        'numeric' => ':Attribute-kentän on oltava vähintään :min.',
        'string' => ':Attribute-kentän merkkijonon on oltava vähintään :min merkkiä.',
    ],
    'min_digits' => ':Attribute-kentän numerossa on oltava vähintään :min numeroa.',
    'missing' => ':Attribute-kentän on oltava puuttuva.',
    'missing_if' => ':Attribute-kentän on oltava puuttuva, kun :other on :value.',
    'missing_unless' => ':Attribute-kentän on oltava puuttuva, ellei :other ole :value.',
    'missing_with' => ':Attribute-kentän on oltava puuttuva, kun :values on läsnä.',
    'missing_with_all' => ':Attribute-kentän on oltava puuttuva, kun :values on läsnä.',
    'multiple_of' => ':Attribute-kentän on oltava :value:n monikerta.',
    'not_in' => 'Valittu :attribute on virheellinen.',
    'not_regex' => ':Attribute-kentän formaatti on virheellinen.',
    'numeric' => ':Attribute-kentän on oltava numero.',
    'password' => [
        'letters' => ':Attribute-kentän on sisällettävä vähintään yksi kirjain.',
        'mixed' => ':Attribute-kentän on sisällettävä vähintään yksi iso- ja pienikirjain.',
        'numbers' => ':Attribute-kentän on sisällettävä vähintään yksi numero.',
        'symbols' => ':Attribute-kentän on sisällettävä vähintään yksi symboli.',
        'not_present' => ':Attribute-kentän ei pitäisi olla läsnä.',
    ],
    'present' => ':Attribute-kentän on oltava läsnä.',
    'prohibited' => ':Attribute-kenttä on kielletty.',
    'prohibited_if' => ':Attribute-kenttä on kielletty, kun :other on :value.',
    'prohibited_unless' => ':Attribute-kenttä on kielletty, ellei :other ole :values.',
    'regex' => ':Attribute-kentän formaatti on virheellinen.',
    'relatable' => ':Attribute-kenttä ei välttämättä liity tähän resurssiin.',
    'required' => ':Attribute-kenttä on pakollinen.',
    'required_if' => ':Attribute-kenttä on pakollinen, kun :other on :value.',
    'required_unless' => ':Attribute-kenttä on pakollinen, ellei :other ole :values.',
    'required_with' => ':Attribute-kenttä on pakollinen, kun :values on läsnä.',
    'required_with_all' => ':Attribute-kenttä on pakollinen, kun :values on läsnä.',
    'required_without' => ':Attribute-kenttä on pakollinen, kun :values ei ole läsnä.',
    'required_without_all' => ':Attribute-kenttä on pakollinen, kun mikään seuraavista ei ole läsnä: :values.',
    'same' => ':Attribute-kentän on oltava sama kuin :other.',
    'size' => [
        'array' => ':Attribute-kentän on oltava :size kohdan taulukko.',
        'file' => ':Attribute-kentän koon on oltava :size kilotavua.',
        'numeric' => ':Attribute-kentän on oltava :size.',
        'string' => ':Attribute-kentän on oltava :size merkkiä.',
    ],
    'starts_with' => ':Attribute-kentän on alkaa seuraavilla: :values.',
    'string' => ':Attribute-kentän on oltava merkkijono.',
    'timezone' => ':Attribute-kentän on oltava validi aikavyöhyke.',
    'unique' => ':Attribute-kenttä on jo otettu.',
    'uploaded' => ':Attribute-kentän lataaminen epäonnistui.',
    'url' => ':Attribute-kentän formaatti on virheellinen.',
    'uuid' => ':Attribute-kentän on oltava validi UUID.',

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
