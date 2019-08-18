<?php declare(strict_types=1);

namespace Tests\Surda\VisualPaginator;

use Surda\VisualPaginator\VisualPaginatorFactory;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class VisualPaginatorExtensionTest extends TestCase
{
    public function testRegistration()
    {
        /** @var Container $container */
        $container = (new ContainerFactory())->create([]);

        /** @var VisualPaginatorFactory $factory */
        $factory = $container->getService('visualPaginator.factory');
        Assert::true($factory instanceof VisualPaginatorFactory);

        /** @var VisualPaginatorFactory $factory */
        $factory = $container->getByType(VisualPaginatorFactory::class);
        Assert::true($factory instanceof VisualPaginatorFactory);
    }
}

(new VisualPaginatorExtensionTest())->run();