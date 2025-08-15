<?php

namespace Crumbly;

/**
 * Configuration object for {@see Crumbly}
 *
 * @since 0.1.1
 */
class CrumblyOptions {
    /**
     * The string displayed between breadcrumb items in the HTML markup
     *
     * @since 0.2.0
     */
    public string $separator = ">";

    function __construct() { }
}