<?php

namespace App\Enums;

use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum Unit: string
{
    use Names, Values;
    case BALL_1_KG = "BALL 1 KG";
    case BALL_2_KG = "BALL 2 KG";
    case BALL_4_KG = "BALL 4 KG";
}
