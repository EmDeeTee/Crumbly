<?php

namespace Crumbly\Path;

/**
 * @since 0.1.0
 */
class CrumblyPathBuilder {
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
     * Adds a node to the path with a title and URL. (Internal constructor call)
     *
     * @param string $title
     * @param string $path
     * @return $this
     * @since 0.1.0
     */
    public function AddRawNode(string $title, string $path): self {
        $this->path[] = new CrumblyPathNode($title, $path);
        return $this;
    }

    /**
     * Builds the CrumblyPath from the added nodes.
     *
     * @return CrumblyPath
     * @since 0.1.0
     */
    public function Build(): CrumblyPath {
        $crumblyPath = new CrumblyPath();

        foreach ($this->path as $node) {
            $crumblyPath->AddNode($node);
        }

        return $crumblyPath;
    }
}