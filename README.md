# Crumbly

```php
public function Breadcrumbs(array $nodes): void {
    $builder = (new CrumblyPathBuilder())
        ->AddNode(new CrumblyPathNode("Home", home_url("/")))
        ->UseEnsureTrailingSlash(true);

    foreach ($nodes as $node) {
        $builder->AddNode($node);
    }

    $options = new CrumblyOptions();
    $options->separator = ":";

    $this->crumbly["object"] = new Crumbly($builder->Build(), $options);
    $this->crumbly["markup"] = (new MarkupGenerator())->Generate($this->crumbly["object"]);
    $this->crumbly["meta"] = (new MetaGenerator())->Generate($this->crumbly["object"]);
}
```

```php
add_action("wp_head", function () {
    if ($this->crumbly["meta"] !== null) {
        echo "<!-- Crumbly Meta -->\n";
        echo "<script type=\"application/ld+json\">\n";
        echo $this->crumbly["meta"];
        echo "\n</script>\n";
    }
});
```
