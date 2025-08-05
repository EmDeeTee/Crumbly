<?php

namespace Crumbly\Path;

use PHPUnit\Framework\TestCase;

use Crumbly\Path\CrumblyPathBuilder;

class CrumblyPathBuilderTest extends TestCase {
    public function testCanBuildValidPath() {
        $pb = new CrumblyPathBuilder();
        $node1 = new CrumblyPathNode('Home', 'http://example.com/home');
        $node2 = new CrumblyPathNode('Products', 'http://example.com/products');
        $node3 = new CrumblyPathNode('Product 1', 'http://example.com/products/1');
        $pb->AddNode($node1)
           ->AddNode($node2)
           ->AddNode($node3);
        $crumblyPath = $pb->Build();
        $this->assertInstanceOf(CrumblyPath::class, $crumblyPath);
        $nodes = $crumblyPath->GetNodes();
        $this->assertCount(3, $nodes);
        $this->assertEquals('Home', $nodes[0]->GetTitle());
        $this->assertEquals('http://example.com/home', $nodes[0]->GetUrl());
        $this->assertEquals('Products', $nodes[1]->GetTitle());
        $this->assertEquals('http://example.com/products', $nodes[1]->GetUrl());
        $this->assertEquals('Product 1', $nodes[2]->GetTitle());
        $this->assertEquals('http://example.com/products/1', $nodes[2]->GetUrl());
    }
}
