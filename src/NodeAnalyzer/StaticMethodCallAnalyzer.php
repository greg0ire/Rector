<?php declare(strict_types=1);

namespace Rector\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use Rector\Node\Attribute;

final class StaticMethodCallAnalyzer
{
    /**
     * Checks "SpecificType::specificMethod()"
     */
    public function isTypeAndMethod(Node $node, string $type, string $method): bool
    {
        if (! $this->isType($node, $type)) {
            return false;
        }

        /** @var StaticCall $node */
        return (string) $node->name === $method;
    }

    /**
     * Checks "SpecificType::oneOfSpecificMethods()"
     *
     * @param string[] $methodNames
     */
    public function isTypeAndMethods(Node $node, string $type, array $methodNames): bool
    {
        if (! $this->isType($node, $type)) {
            return false;
        }

        /** @var StaticCall $node */
        $currentMethodName = (string) $node->name;

        foreach ($methodNames as $methodName) {
            if ($currentMethodName === $methodName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string[] $types
     * @return string[]
     */
    public function matchTypes(Node $node, array $types): ?array
    {
        if (! $node instanceof StaticCall) {
            return null;
        }

        if (! $node->name instanceof Identifier) {
            return null;
        }

        if (! $node->class instanceof Name) {
            return null;
        }

        $nodeTypes = $node->class->getAttribute(Attribute::TYPES);

        return array_intersect($nodeTypes, $types) ? $nodeTypes : null;
    }

    /**
     * Checks "SpecificType::anyMethod()"
     */
    private function isType(Node $node, string $type): bool
    {
        if (! $node instanceof StaticCall) {
            return false;
        }

        $callerTypes = (array) $node->getAttribute(Attribute::CALLER_TYPES);

        return in_array($type, $callerTypes, true);
    }
}
