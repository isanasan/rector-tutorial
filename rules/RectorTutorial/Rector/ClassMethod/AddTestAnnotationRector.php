<?php

declare(strict_types=1);

namespace Rector\RectorTutorial\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\ClassLike;
use PHPUnit\Framework\TestCase;
use PHPStan\Type\ObjectType;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use Rector\Core\Rector\AbstractRector;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit\PHPUnitTest;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\RectorTutorial\Rector\ClassMethod\AddTestAnnotationRector\AddTestAnnotationRectorTest
 */
final class AddTestAnnotationRector extends AbstractRector
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rector Tutorial', [new CodeSample(
            <<<'CODE_SAMPLE'
class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function testSome() : void
    {
        // do test
    }
}
CODE_SAMPLE,
            <<<'CODE_SAMPLE'
class SomeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function some() : void
    {
        // do test
    }
}
CODE_SAMPLE
        )]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->shouldRefactor($node)) {
            return null;
        }

        // メソッドの PHP Doc を取得
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);

        $phpDocInfo->addPhpDocTagNode(
            new PhpDocTagNode('@test', new GenericTagValueNode(''))
        );

        // 元のメソッド名から `test` prefix を削除し, 1文字目を小文字に変更した文字列
        $testName = \lcfirst(
            (string) \preg_replace('/\Atest/', '', (string) $this->getName($node))
        );
        // `$testName` を新しいメソッド名として設定しなおす
        $node->name = new Node\Identifier($testName);

        // change the node
        return $node;
    }

    private function shouldRefactor(ClassMethod $node): bool
    {
        // クラスメソッドが実装されているクラス情報を取得
        $class = $this->betterNodeFinder->findParentType($node, ClassLike::class);

        return
            // メソッドの可視性が public かどうか
            $node->isPublic()
            // メソッド名が `test` から始まっているかどうか
            && $this->isName($node, 'test*')
            // メソッドが実装されているクラスが `PHPUnit\Framework\TestCase` を継承しているかどうか
            && $this->nodeTypeResolver->isObjectType(
                $class,
                new ObjectType(TestCase::class),
            );
    }
}
