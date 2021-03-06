<?php declare(strict_types=1);

namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver;

use PhpParser\Node\Stmt\Property;
use Rector\Node\Attribute;
use Rector\NodeTypeResolver\Tests\AbstractNodeTypeResolverTest;

final class Test extends AbstractNodeTypeResolverTest
{
    public function testDocBlock(): void
    {
        $propertyNodes = $this->getNodesForFileOfType(
            __DIR__ . '/Source/DocBlockDefinedProperty.php.inc',
            Property::class
        );

        $this->assertSame(
            ['SomeNamespace\PropertyType'],
            $propertyNodes[0]->getAttribute(Attribute::TYPES)
        );
    }

    public function testConstructorType(): void
    {
        $propertyNodes = $this->getNodesForFileOfType(
            __DIR__ . '/Source/ConstructorDefinedProperty.php.inc',
            Property::class
        );

        $this->assertSame(
            ['SomeNamespace\PropertyType'],
            $propertyNodes[0]->getAttribute(Attribute::TYPES)
        );
    }

    public function testPartialDocBlock(): void
    {
        $propertyNodes = $this->getNodesForFileOfType(
            __DIR__ . '/Source/PartialDocBlock.php.inc',
            Property::class
        );

        $this->assertSame(
            ['PhpParser\Node\Stmt\ClassMethod', 'PhpParser\Node\Stmt\Function_', 'PhpParser\Node\Expr\Closure'],
            $propertyNodes[0]->getAttribute(Attribute::TYPES)
        );
    }
}
