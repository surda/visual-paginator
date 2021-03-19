<?php declare(strict_types=1);

namespace Surda\VisualPaginator;

use Nette\Utils\Paginator;

trait InjectVisualPaginator
{
    /** @var VisualPaginatorFactory */
    private $visualPaginatorFactory;

    /** @var Paginator */
    private $paginator;

    /**
     * @param VisualPaginatorFactory $visualPaginatorFactory
     */
    public function injectVisualPaginatorFactory(VisualPaginatorFactory $visualPaginatorFactory): void
    {
        $this->visualPaginatorFactory = $visualPaginatorFactory;

        $this->onStartup[] = function () {
            /** @var VisualPaginatorControl $vp */
            $vp = $this->getComponent('vp');

            /** @var Paginator $paginator */
            $this->paginator = $vp->getPaginator();
        };
    }

    /**
     * @return VisualPaginatorControl
     */
    protected function createComponentVp(): VisualPaginatorControl
    {
        return $this->visualPaginatorFactory->create();
    }
}