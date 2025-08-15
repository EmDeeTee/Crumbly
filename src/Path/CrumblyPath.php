<?php

namespace Crumbly\Path;

/**
 * Represents a breadcrumb path made of {@see CrumblyPathNode} nodes.
 *
 * @see CrumblyPathNode
 * @since 0.1.0
 */
class CrumblyPath {
    /**
     * @readonly
     * @var CrumblyPathNode[]
     */
    private array $path = [];

    /**
     * @param CrumblyPathNode[] $nodes
     * @since 0.2.0
     */
    public function __construct(array $nodes) {
        $this->path = $nodes;
    }

    /**
     * Converts the path to an array of nodes.
     *
     * @return CrumblyPathNode[]
     * @since 0.1.0
     */
    public function GetNodes(): array {
        return $this->path;
    }
}
