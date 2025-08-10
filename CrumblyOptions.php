<?php

namespace Crumbly;

use Crumbly\Path\CrumblyPathNode;

// QNA: Is this a good idea? A config object with all members being public
/**
 * @since 0.1.1
 */
class CrumblyOptions {
    /**
     * This option will ensure that all {@see CrumblyPathNode} nodes will have a trailing slash
     *
     * @since 0.1.1
     */
    public bool $EnsureTrailingSlash = false;

    function __construct() { }
}