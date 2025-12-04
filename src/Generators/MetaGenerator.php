<?php
declare(strict_types=1);

namespace Crumbly\Generators;

use Crumbly\Crumbly;
use Crumbly\Path\CrumblyPath;

class MetaGenerator implements GeneratorContract {
    public function Generate(Crumbly $crumbly, CrumblyPath $path): string {
        $breadcrumbItems = array_map(function($entry) {
            return [
                "@type" => "ListItem",
                "position" => $entry['index'] + 1,
                "name" => $entry['title'],
                "item" => $entry['url'],
            ];
        }, $path->GetBreadcrumbList());

        $json = wp_json_encode([
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $breadcrumbItems,
        ]);
    }
}