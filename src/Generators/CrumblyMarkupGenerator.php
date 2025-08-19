<?php

namespace Crumbly\Generators;

use Crumbly\Crumbly;
use Crumbly\Path\CrumblyPath;

/**
 * Class containing the HTML generator
 *
 * @since 0.2.0
 */
class CrumblyMarkupGenerator implements CrumblyGenerator
{
    /**
     * Generates and returns the HTML markup for the breadcrumb list
     *
     * @since 0.2.0
     */
    public function Generate(Crumbly $crumbly, CrumblyPath $path): string {
        $nodes = $path->GetBreadcrumbList();

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
                $html .= "<li class='crumbly-separator'>{$crumbly->GetOptions()->separator}</li>";
            }
        }
        $html .= '</ol></nav>';

        return $html;
    }
}