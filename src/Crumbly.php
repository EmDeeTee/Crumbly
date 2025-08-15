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
     * Generates the HTML markup for the breadcrumbs.
     * Root class is `crumbly`, and each item has the class `crumbly-item`.
     *
     * @since 0.1.0
     */
    public function GenerateMarkup(): string {
        $nodes = $this->GetBreadcrumbList();
        if (empty($nodes)) {
            return '';
        }

        $html = '<nav class="crumbly-nav" aria-label="Breadcrumbs"><ol class="crumbly">';

        foreach ($nodes as $index => $node) {
            $title = htmlspecialchars($node['title'], ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars($node['url'], ENT_QUOTES, 'UTF-8');

            if ($index === count($nodes) - 1) {
                $html .= "<li class='crumbly-item active' aria-current='page'>{$title}</li>";
            } else {
                $html .= "<li class='crumbly-item'><a href='{$url}'>{$title}</a></li>";
                $html .= "<li class='crumbly-separator'>{$this->options->separator}</li>";
            }
        }
        $html .= '</ol></nav>';

        return $html;
    }

    //TODO: Split these two methods into separate classes
    //TODO: Make EmbedMeta just return the JSON-LD with the breadcrumbs

    /**
     * Generates and embeds the Google BreadcrumbList JSON into a meta tag in <head> of the page.
     *
     * @since 0.1.0
     */
    public function EmbedMeta(): void {
        add_action('wp_head', function() {
            $breadcrumbItems = array_map(function($entry) {
                return [
                    "@type" => "ListItem",
                    "position" => $entry['index'] + 1,
                    "name" => $entry['title'],
                    "item" => $entry['url'],
                ];
            }, $this->GetBreadcrumbList());

            ?>
            <script type="application/ld+json">
              <?= json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "BreadcrumbList",
                    "itemListElement" => $breadcrumbItems
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
            </script>
            <?php
        });
        // QNA: Is this safe/good?
        // QNA: How do I unit test with this? Can I not call the function by wrapping it with an 'if'?
        wp_head();
    }

    //TODO: Nuke this method and make it into a file

    /**
     * Gets the static CSS styles for the breadcrumbs.
     *
     * @since 0.1.0
     */
    public static function GetStyle(): string {
        // QNA: Feels kinda scuffed. Should it be a separate file or something else?
        return '
            <style>
                .crumbly {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                    color: black;
                    font-size: 16px;
                }
            </style>
        ';
    }

    /**
     * Gets the breadcrumb list as an array for use easier use.
     *
     * @return array<int, array{title: string, url: string, index: int}>
     * @since 0.1.0
     */
    private function GetBreadcrumbList(): array {
        $nodes = $this->path->GetNodes();

        return array_map(function($node, $index) {
            return [
                'title' => htmlspecialchars($node->GetTitle(), ENT_QUOTES, 'UTF-8'),
                'url' => htmlspecialchars($node->GetUrl(), ENT_QUOTES, 'UTF-8'),
                'index' => $index
            ];
        }, $nodes, array_keys($nodes));
    }
}
