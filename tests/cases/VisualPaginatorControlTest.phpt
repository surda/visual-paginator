<?php declare(strict_types=1);

namespace Tests\Surda\VisualPaginator;

use Nette\DI\Container;
use Nette\Utils\Paginator;
use Surda\VisualPaginator\VisualPaginatorControl;
use Surda\VisualPaginator\VisualPaginatorFactory;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

/**
 * @testCase
 */
class VisualPaginatorControlTest extends TestCase
{
    public function testControl()
    {
        $config = [
            'visualPaginator' => [
                'edges' => 2,
                'displayedPages' => 9,
            ]
        ];

        /** @var Container $container */
        $container = (new ContainerFactory())->create($config,1);

        /** @var VisualPaginatorFactory $factory */
        $factory = $container->getService('visualPaginator.factory');

        /** @var VisualPaginatorControl $control */
        $control = $factory->create();

        Assert::true($control->getPaginator() instanceof Paginator);

        Assert::same(9, $control->getDisplayedPages());
        Assert::same(2, $control->getEdges());

        $control->setDisplayedPages(7);
        Assert::same(7, $control->getDisplayedPages());

        $control->setEdges(3);
        Assert::same(3, $control->getEdges());
    }
}

(new VisualPaginatorControlTest())->run();