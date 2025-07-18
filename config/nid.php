<?php
return [
    'auth_url'=> 'https://verify-nin-citizenportal.donidcr.gov.np/auth/token',
    'verification_url'=>'https://verify-nin-citizenportal.donidcr.gov.np/api/nin/verify',
    'grant_type'=>'client_credentials',
    'username'=>env('NID_USERNAME'),
    'password'=>env('NID_PASSWORD'),
];