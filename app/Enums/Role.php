<?php

namespace App\Enums;

use ArchTech\Enums\Names;

enum Role {
    use Names;
    case ADMINISTRATOR;
    case KEPALA_TOKO;
    case KEPALA_GUDANG;
}
