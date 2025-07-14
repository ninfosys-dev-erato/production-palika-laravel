<?php

namespace Src\Ejalas\Enum;

enum MediatorSelectionType: string
{
    case mutuallySelected = 'Mutually Selected';
    case selectedByFirstParty = 'Selected by First Party';
    case selectedBySecondParty = 'Selected by Second Party';
    case selectedByBothParty = 'Selected by Both Party';
}
