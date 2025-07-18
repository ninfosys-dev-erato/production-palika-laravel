<?php

namespace Src\Settings\Enums;

enum KeyType : string
{
    CASE DISTRICT = 'Src\Districts\Models\District';
    CASE WARDS = 'Src\Wards\Models\Ward';

    case PROVINCE = 'Src\Provinces\Models\Province';
    case LOCAL_BODIES = 'Src\LocalBodies\Models\LocalBody';

    case FISCAL_YEAR = 'Src\FiscalYears\Models\FiscalYear';

    case ROLE = 'Src\Roles\Models\Role';

    case PERMISSION = 'Src\Permissions\Models\Permission';

    case USER = 'App\Models\User';
}
