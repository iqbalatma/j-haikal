<?php

namespace App\Enums\Enums;

use ArchTech\Enums\Names;

enum TransactionType {
    use Names;
    case RESTOCK;
    case SALE;
    case EXPIRED;
    case BROKEN;
}
