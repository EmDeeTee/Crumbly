<?php

namespace Crumbly\Path;

/**
 * TODO: Add a ref thinggy, for clarity
 * Represents a single node in the breadcrumb path.
 *
 * @since 0.1.0
 */
class CrumblyPathNode {
    private string $title;
    private string $url;

    public function __construct($title, $url) {
        $this->title = $title;
        $this->url = $url;
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

    /**
     * If the node URL doesn't contain a trailing slash, adds it
     *
     * If the URL already has a slash, does nothing
     *
     * @since 0.1.1
     */
    public function EnsureUrlTrailingSlash() : void {
        if (substr($this->url, -1) !== '/') {
            $this->url .= '/';
        }
    }

    // TODO: Is this even needed?
    //       If it is, add a proper return type
    /**
     * @since 0.1.0
     */
    public function ToArray() {
        return [
            'title' => $this->title,
            'url' => $this->url->toString(),
        ];
    }
}
