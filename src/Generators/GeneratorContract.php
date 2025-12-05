<?php
declare(strict_types=1);

namespace Crumbly\Generators;

use Crumbly\Crumbly;

/**
 * Base for Crumbly generators
 *
 * @since 1.0.0
 */
interface GeneratorContract {
    public function Generate(Crumbly $crumbly): string;
}