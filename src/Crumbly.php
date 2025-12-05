<?php
declare(strict_types=1);

namespace Crumbly;

use Crumbly\Path\CrumblyPath;

/**
 * @since 0.1.0
 */
final class Crumbly {
    private CrumblyPath $path;
    private CrumblyOptions $options;

    /**
     * @param CrumblyPath $path The path from which to generate the markup and Google's BreadcrumbList JSON
     * @param CrumblyOptions|null $options The config that alters the generators. A default config will be created if null is passed
     */
    public function __construct(CrumblyPath $path, CrumblyOptions $options = null) {
        $this->path = $path;
        $this->options = $options ?? new CrumblyOptions();
    }

    /**
     * Gets the path of the breadcrumbs in the current {@see CrumblyPath}.
     *
     * @since 0.1.0
     */
    public function GetPath(): CrumblyPath {
        return $this->path;
    }

    /**
     * Gets the separator used in the breadcrumbs.
     *
     * The separator is changed by the {@see CrumblyOptions} options
     *
     * @since 0.1.0
     */
    public function GetSeparator(): string {
        return $this->options->separator;
    }

    /**
     * Gets the active options of the Crumbly instance
     *
     * @since 0.2.0
     */
    public function GetOptions(): CrumblyOptions {
        return $this->options;
    }
}
