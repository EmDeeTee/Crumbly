<?php
declare(strict_types=1);

namespace Crumbly\Path;

/**
 * Represents a single node in the breadcrumb {@see CrumblyPath} path.
 *
 * @see CrumblyPath
 * @since 0.1.0
 */
class CrumblyPathNode {
    private string $title;
    private string $url;

    /**
     * @param string $title Display name of the node. Will be visible in the markup and Google's BreadcrumbList JSON
     * @param string $url The URL to the page this node represents. Will be used in the markup as a href and in Google's BreadcrumbList JSON
     */
    public function __construct(string $title, string $url, bool $ensureTrailingSlash = false) {
        $this->title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, "UTF-8");
        $this->url = $url;

        if ($ensureTrailingSlash && !str_ends_with($this->url, '/')) {
            $this->url .= '/';
        }
    }

    /**
     * Gets the title of the breadcrumb node.
     *
     * @since 0.1.0
     */
    public function GetTitle(): string {
        return $this->title;
    }

    /**
     * Gets the URL of the breadcrumb node.
     *
     * @since 0.1.0
     */
    public function GetUrl(): string {
        return $this->url;
    }
}
