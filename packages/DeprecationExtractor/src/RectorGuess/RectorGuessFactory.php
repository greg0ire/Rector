<?php declare(strict_types=1);

namespace Rector\DeprecationExtractor\RectorGuess;

use PhpParser\Node;
use Rector\Rector\Dynamic\ArgumentReplacerRector;
use Rector\Rector\Dynamic\ClassReplacerRector;
use Rector\Rector\Dynamic\MethodNameReplacerRector;

final class RectorGuessFactory
{
    public function createClassReplacer(string $message, Node $node): RectorGuess
    {
        return new RectorGuess(ClassReplacerRector::class, $node, $message);
    }

    public function createMethodNameReplacerGuess(string $message, Node $node): RectorGuess
    {
        return new RectorGuess(MethodNameReplacerRector::class, $node, $message);
    }

    public function createNewArgument(string $message, Node $node): RectorGuess
    {
        return new RectorGuess(ArgumentReplacerRector::class, $node, $message);
    }

    public function createRemoval(string $message, Node $node): RectorGuess
    {
        return new RectorGuess(RectorGuess::TYPE_REMOVAL, $node, $message);
    }

    public function createUnsupported(string $message, Node $node): RectorGuess
    {
        return new RectorGuess(RectorGuess::TYPE_UNSUPPORTED, $node, $message);
    }
}
