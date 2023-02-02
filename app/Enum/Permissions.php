<?php

namespace App\Enum;

enum Permissions
{
    case create;
    case update;
    case delete;
    case all;
}
