<?php

namespace App\Enums;

enum StatusResponseEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case FAIL = 'fail';
}
