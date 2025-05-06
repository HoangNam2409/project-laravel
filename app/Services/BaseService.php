<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    public function __construct() {}

    // Current Language
    public function currentLanguage()
    {
        return 1;
    }
}
