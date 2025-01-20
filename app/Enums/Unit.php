<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum Unit
{
    use Names;
    case KILOGRAM;
    case GRAM;
    case TON;
    case MILIGRAM;
    case MILILITER;
    case LITER;
    case BUAH;
}
