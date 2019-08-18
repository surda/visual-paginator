<?php declare(strict_types=1);

namespace Surda\VisualPaginator;

interface VisualPaginatorFactory
{
    /**
     * @return VisualPaginatorControl
     */
    public function create(): VisualPaginatorControl;
}
