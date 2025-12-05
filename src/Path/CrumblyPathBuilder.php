<?php
declare(strict_types=1);

namespace Crumbly\Path;

use JetBrains\PhpStorm\Deprecated;

// NOTE: Should this be static?
/**
 * @since 0.1.0
 */
#[Deprecated]
class CrumblyPathBuilder {
    /**
     * @var CrumblyPathNode[]
     */
    private array $path = [];
    private bool $ensureTrailingSlash = false;

    /**
     * Adds a node to the path.
     *
     * @since 0.1.0
     */
    public function AddNode(CrumblyPathNode $node): self {
        $this->path[] = $node;
        return $this;
    }

    /**
     * If the node URL doesn't contain a trailing slash, adds it
     *
     * If the URL already has a slash, does nothing
     *
     * For example, https://website/product would become https://website/product/
     *
     * @since 0.2.0
     */
    public function UseEnsureTrailingSlash(bool $val): self {
        $this->ensureTrailingSlash = $val;
        return $this;
    }

    /**
     * Builds the CrumblyPath from the added nodes.
     *
     * @return CrumblyPath
     * @since 0.1.0
     */
    public function Build(): CrumblyPath {
        $finalNodes = [];

        foreach ($this->path as $node) {
            $url = $node->GetUrl();

            if ($this->ensureTrailingSlash && !str_ends_with($url, '/')) {
                $finalNodes[] = new CrumblyPathNode($node->GetTitle(), $url . '/');
            } else {
                $finalNodes[] = $node;
            }
        }

        return new CrumblyPath($finalNodes);
    }
}