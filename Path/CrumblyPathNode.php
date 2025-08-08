<?php

namespace Crumbly\Path;

use http\Url;

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
     * @return string
     * @since 0.1.0
     */
    public function GetTitle(): string {
        return $this->title;
    }

    /**
     * Gets the URL of the breadcrumb node.
     *
     * @return Url
     * @since 0.1.0
     */
    public function GetUrl(): string {
        return $this->url;
    }

    public function ToArray() {
        return [
            'title' => $this->title,
            'url' => $this->url->toString(),
        ];
    }
}
