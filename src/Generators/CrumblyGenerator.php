<?php

namespace Crumbly\Generators;

use Crumbly\Crumbly;
use Crumbly\Path\CrumblyPath;

/**
 * Base for Crumbly generators
 *
 * @since 0.2.0
 */
interface CrumblyGenerator {
    public function Generate(Crumbly $crumbly, CrumblyPath $path): string;
}