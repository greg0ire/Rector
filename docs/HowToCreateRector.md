### 6 Steps to New Rector
 
1. Just extend `Rector\Rector\AbstractRector` class. It will prepare **2 methods**:
 
    ```php
    public function isCandidate(Node $node): bool
    {
    }
    
    public function refactor(Node $node): ?Node
    {
    }
    ```
 
2. Put it under `namespace Rector\Contrib\<set>;` namespace
    
    ```php
    <?php declare(strict_types=1);
    
    namespace Rector\Contrib\Symfony;
    
    use Rector\Rector\AbstractRector;
    
    final class MyRector extends AbstractRector
    {
     // ...
    }
    ```

3. Add a Test Case
 
4. Add to specific level, e.g. [`/src/config/level/nette/nette24.yml`](/src/config/level/nette/nette24.yml)
 
5. Submit PR
 
6. :+1:
