<?php

return [

    'next'                  => 'Nästa',
    'refresh'               => 'Uppdatera',

    'steps' => [
        'requirements'      => 'Snälla, be webbhotellet åtgärda felen!',
        'language'          => 'Steg 1/3: Språkval',
        'database'          => 'Steg 2/3: Databasinställningar',
        'settings'          => 'Steg 3/3: Företag och Admin uppgifter',
    ],

    'language' => [
        'select'            => 'Välj språk',
    ],

    'requirements' => [
        'enabled'           => ':feature måste vara aktiverad!',
        'disabled'          => ':feature måste inaktiveras!',
        'extension'         => ':extension tillägget måste vara installerad och laddad!',
        'directory'         => ':directory katalogen måste vara skrivbar!',
    ],

    'database' => [
        'hostname'          => 'Hostnamn',
        'username'          => 'Användarnamn',
        'password'          => 'Lösenord',
        'name'              => 'Databas',
    ],

    'settings' => [
        'company_name'      => 'Företagets namn',
        'company_email'     => 'Företagets e-post',
        'admin_email'       => 'Admin e-postadress',
        'admin_password'    => 'Admin lösenord',
    ],

    'error' => [
        'connection'        => 'Fel: Kunde inte ansluta till databasen! Snälla, se till att uppgifterna stämmer.',
    ],

];
