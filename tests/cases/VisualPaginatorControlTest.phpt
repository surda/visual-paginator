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
        $container = (new ContainerFactory())->create($config, 1);

        /** @var VisualPaginatorFactory $factory */
        $factory = $container->getService('visualPaginator.factory');

        /** @var VisualPaginatorControl $control */
        $control = $factory->create();

        $control->setPaginator(new Paginator());
        Assert::true($control->getPaginator() instanceof Paginator);

        Assert::same(9, $control->getDisplayedPages());
        Assert::same(2, $control->getEdges());

        $control->setDisplayedPages(7);
        Assert::same(7, $control->getDisplayedPages());

        Assert::exception(function () use ($control) {
            $control->setDisplayedPages(2);
        }, \Surda\VisualPaginator\Exception\InvalidArgumentException::class, 'Invalid argument \'displayedPages\'. Argument must be equal to or greater than 3');

        $control->setEdges(3);
        Assert::same(3, $control->getEdges());

        Assert::exception(function () use ($control) {
            $control->setEdges(0);
        }, \Surda\VisualPaginator\Exception\InvalidArgumentException::class, 'Invalid argument \'edges\'. Argument must be equal to or greater than 1');
    }
}

(new VisualPaginatorControlTest())->run();