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
     * Adds a node to the path.
     *
     * @param CrumblyPathNode $node
     * @return $this
     * @since 0.1.0
     */
    public function AddNode(CrumblyPathNode $node): self {
        $this->path[] = $node;
        return $this;
    }

    /**
     * Converts the path to an array of nodes.
     *
     * @return array
     * @since 0.1.0
     */
    public function GetNodes(): array {
        return $this->path;
    }
}
