<?php
declare(strict_types=1);

namespace Crumbly\Generators;

use Crumbly\Crumbly;

/**
 * Generates JSON-LD metadata for breadcrumbs.
 *
 * @since 1.0.0
 */
class MetaGenerator implements GeneratorContract {
    public function Generate(Crumbly $crumbly): string {
        $breadcrumbItems = array_map(function($entry) {
            return [
                "@type" => "ListItem",
                "position" => $entry['index'] + 1,
                "name" => $entry['title'],
                "item" => $entry['url'],
            ];
        }, $crumbly->GetPath()->GetBreadcrumbList());

        $json = wp_json_encode([
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => $breadcrumbItems,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if (!$json) {
            return "CRUMBLY ERROR: Failed to generate JSON-LD for breadcrumb metadata. wp_json_encode error: " . json_last_error_msg();
        }

        return $json;
    }
}