<?php


namespace Src\FileTracking\Enums;

enum InboxPage: string{

    case ALL = 'all';
    case FARSYAUT  = 'farsyaut';
    case NO_FARSYAUT  = 'no-farsyaut';
    case ARCHIVED  = 'archived';
    case STARRED  = 'starred';
    case SENT      = 'sent';
}