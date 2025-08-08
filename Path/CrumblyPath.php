<?php

namespace Crumbly\Path;

use ArrayIterator;
use Traversable;
use IteratorAggregate;

/**
 * Represents a breadcrumb path made of {@see CrumblyPathNode} nodes.
 *
 * @implements IteratorAggregate<int,CrumblyPathNode>
 * @see CrumblyPathNode
 * @since 0.1.0
 */
class CrumblyPath implements IteratorAggregate {
    /**
     * @readonly
     * @var CrumblyPathNode[]
     */
    private array $path = [];

    /**
     * Adds a node to the path.
     *
     * @param CrumblyPathNode $node
     * @since 0.1.0
     */
    public function AddNode(CrumblyPathNode $node): CrumblyPath {
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

    // QNA: Isn't this pointless if we have GetNodes()?
    // If it's only for ergonomics... Also, quite difficult to type properly
    /**
     * Implemented for {@see IteratorAggregate}
     *
     * @since 0.1.1
     */
    public function getIterator(): Traversable {
        return new ArrayIterator($this->path);
    }
}
