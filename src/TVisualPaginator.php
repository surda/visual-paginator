<?php declare(strict_types=1);

namespace Surda\VisualPaginator;

/**
 * @deprecated
 */
trait TVisualPaginator
{
    /** @var VisualPaginatorFactory */
    private $visualPaginatorFactory;

    /**
     * @param VisualPaginatorFactory $visualPaginatorFactory
     */
    public function injectVisualPaginatorFactory(VisualPaginatorFactory $visualPaginatorFactory): void
    {
        $this->visualPaginatorFactory = $visualPaginatorFactory;
    }

    /**
     * @return VisualPaginatorControl
     */
    protected function createComponentVp(): VisualPaginatorControl
    {
        return $this->visualPaginatorFactory->create();
    }
}