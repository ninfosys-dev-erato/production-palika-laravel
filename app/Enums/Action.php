<?php

namespace App\Enums;

enum Action:string
{
    case DELETE = 'delete';
    case UPDATE = 'update';
    case CREATE = 'create';
    case DELETED = 'deleted';
    case UPDATED = 'updated';
    case CREATED = 'created';

}
