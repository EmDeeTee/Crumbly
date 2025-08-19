<?php

namespace Crumbly\Path;

/**
 * Represents a breadcrumb path made of {@see CrumblyPathNode} nodes.
 *
 * Constructed using {@see CrumblyPathBuilder}
 *
 * @see CrumblyPathNode
 * @see CrumblyPathBuilder
 * @since 0.1.0
 */
class CrumblyPath {
    /**
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

    /**
     * Gets the breadcrumb list as an array for use easier use.
     *
     * @return array<int, array{title: string, url: string, index: int}>
     * @since 0.2.0
     */
    public function GetBreadcrumbList(): array {
        $nodes = $this->GetNodes();

        return array_map(function($node, $index) {
            return [
                'title' => htmlspecialchars($node->GetTitle(), ENT_QUOTES, 'UTF-8'),
                'url' => htmlspecialchars($node->GetUrl(), ENT_QUOTES, 'UTF-8'),
                'index' => $index
            ];
        }, $nodes, array_keys($nodes));
    }
}
