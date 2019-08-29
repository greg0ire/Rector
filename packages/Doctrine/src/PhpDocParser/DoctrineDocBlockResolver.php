<?php declare(strict_types=1);

namespace Rector\Doctrine\PhpDocParser;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\DoctrinePhpDocParser\Ast\PhpDoc\Property_\TableTagValueNode;
use Rector\DoctrinePhpDocParser\Contract\Ast\PhpDoc\DoctrineRelationTagValueNodeInterface;
use Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;

final class DoctrineDocBlockResolver
{
    /**
     * @var DocBlockManipulator
     */
    private $docBlockManipulator;

    public function __construct(DocBlockManipulator $docBlockManipulator)
    {
        $this->docBlockManipulator = $docBlockManipulator;
    }

    public function isDoctrineEntityClass(Class_ $class): bool
    {
        $classPhpDocInfo = $this->getPhpDocInfo($class);
        if ($classPhpDocInfo === null) {
            return false;
        }

        return (bool) $classPhpDocInfo->getDoctrineEntityTag();
    }

    public function getTargetEntity(Property $property): ?string
    {
        $doctrineRelationTagValueNode = $this->getDoctrineRelationTagValueNode($property);
        if ($doctrineRelationTagValueNode === null) {
            return null;
        }

        return $doctrineRelationTagValueNode->getTargetEntity();
    }

    public function hasPropertyDoctrineIdTag(Property $property): bool
    {
        $propertyPhpDocInfo = $this->getPhpDocInfo($property);
        if ($propertyPhpDocInfo === null) {
            return false;
        }

        return (bool) $propertyPhpDocInfo->getDoctrineIdTagValueNode();
    }

    public function getDoctrineRelationTagValueNode(Property $property): ?DoctrineRelationTagValueNodeInterface
    {
        $propertyPhpDocInfo = $this->getPhpDocInfo($property);
        if ($propertyPhpDocInfo === null) {
            return null;
        }

        return $propertyPhpDocInfo->getDoctrineRelationTagValueNode();
    }

    public function getDoctrineTableTagValueNode(Class_ $class): ?TableTagValueNode
    {
        $classPhpDocInfo = $this->getPhpDocInfo($class);
        if ($classPhpDocInfo === null) {
            return null;
        }

        return $classPhpDocInfo->getDoctrineTableTagValueNode();
    }

    public function isDoctrineProperty(Property $property): bool
    {
        $propertyPhpDocInfo = $this->getPhpDocInfo($property);
        if ($propertyPhpDocInfo === null) {
            return false;
        }

        if ($propertyPhpDocInfo->getDoctrineColumnTagValueNode()) {
            return true;
        }

        if ($propertyPhpDocInfo->getDoctrineRelationTagValueNode()) {
            return true;
        }

        return false;
    }

    private function getPhpDocInfo(Node $node): ?PhpDocInfo
    {
        if ($node->getDocComment() === null) {
            return null;
        }

        return $this->docBlockManipulator->createPhpDocInfoFromNode($node);
    }
}