<?php

namespace Crumbly;

// TODO: Automatic CSS injection using a hook/action? see - admin_head
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

// QNA: What should the structure be? Right not it's all in root

use Crumbly\Path\CrumblyPath;

/**
 * @since 0.1.0
 */
class Crumbly {
    // QNA: Are all these @readonly needed?

    /**
     * @since 0.1.0
     * @readonly
     */
    private CrumblyPath $path;
    /**
     * @since 0.1.0
     * @readonly
     */
    private string $separator;
    /**
     * @since 0.1.1
     */
    private CrumblyOptions $options;

    // TODO: The constructor is getting quite long...
    //       Maybe something like Crumbly->UseConfig() is in order? Instead of passing it in the constructor
    //       Also, Maybe add a method like Crumbly->ApplyConfig()? Because I don't know how I feel about
    //       Having the trail-ensuring logic right out in the open like that
    //
    //       P.S. Shouldn't the $separator also be migrated to a config? Since not it's a possibility
    public function __construct(CrumblyPath $path, string $separator = '>', CrumblyOptions $config = null) {
        $this->path = $path;
        $this->separator = $separator;
        $this->options = $config ?? new CrumblyOptions();

        // TODO: This is probably overcomplicated. Just call CrumblyPath->GetNodes() instead of implementing Traversable
        // FIXME: Move this to CrumblyPathBuilder
        if ($this->options->EnsureTrailingSlash) {
            foreach ($this->path as $node) {
                $node->EnsureUrlTrailingSlash();
            }
        }
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
     * @since 0.1.0
     */
    public function GetSeparator(): string {
        return $this->separator;
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
                $html .= "<li class='crumbly-separator'>{$this->separator}</li>";
            }
        }
        $html .= '</ol></nav>';

        return $html;
    }

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
