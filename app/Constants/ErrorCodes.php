<?php

namespace App\Constants;

class ErrorCodes
{
    const ROUTE_NOT_FOUND = -10001;
    const MODEL_NOT_FOUND = -10004;

    const EDIT_ID_NOT_SAME = -80001;
    const ERROR_WHILE_SAVING = -80002;

    const MODEL_CANNOT_BE_DELETED = -90001;
    const ERROR_WHILE_DELETING = -90002;

    const SERVER_ERROR = -99001;
}
