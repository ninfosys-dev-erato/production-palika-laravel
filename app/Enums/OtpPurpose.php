<?php

namespace App\Enums;

enum OtpPurpose:string
{
    case SIGNUP = 'signup';
    case FORGOTPASSWORD = 'forgot-password';
    case RESENT = 'resent';
   
}
