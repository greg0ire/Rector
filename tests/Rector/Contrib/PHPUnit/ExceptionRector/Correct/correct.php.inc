<?php declare(strict_types=1);

final class MyTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->expectException('SomeException');
        $this->expectException('SomeException');
        $this->expectExceptionMessage($message);
    }
}
