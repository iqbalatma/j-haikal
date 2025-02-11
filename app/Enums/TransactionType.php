<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum TransactionType {
    use Names;
    case RESTOCK;
    case SALE;
}
