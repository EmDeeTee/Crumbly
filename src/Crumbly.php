<?php

namespace Crumbly;

// TODO: Add an ability to define a default home node for the path
// TODO: Integrate a helper function. SOmething like:
//function CrumblyMakeCrumbs(array $nodes, bool $embedMeta): string {
//    $pb = new CrumblyPathBuilder();
//
//    $pb->AddRawNode(
//        'Home',
//        get_permalink(get_the_ID()),
//    );
//
//    foreach ($nodes as $node) {
//        $pb->AddRawNode($node['title'], $node['url']);
//    }
//
//    $c = new Crumbly($pb->Build());
//    $c->EmbedMeta();
//    return $c->GenerateMarkup();
//}

use Crumbly\Path\CrumblyPath;

/**
 * A facade that allows you to generate the Google's BreadcrumbList JSON and markup of the breadcrumb menu from a {@see CrumblyPath} path
 *
 * @since 0.1.0
 */
class Crumbly {
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

    //TODO: Split these two methods into separate classes
    //TODO: Make EmbedMeta just return the JSON-LD with the breadcrumbs
}
