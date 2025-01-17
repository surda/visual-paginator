<?php declare(strict_types=1);

namespace Surda\VisualPaginator;

use Nette\Application\UI\ITemplate;
use Surda\UI\Control\ThemeableControls;
use Nette\Application\UI;
use Nette\Utils\Paginator;
use Surda\VisualPaginator\Exception\InvalidArgumentException;

class VisualPaginatorControl extends UI\Control
{
    use ThemeableControls;

    /**
     * @var int
     * @persistent
     */
    public $page = 1;

    /** @var bool */
    protected $useAjax = FALSE;

    /** @var Paginator */
    protected $paginator;

    /** @var int */
    protected $displayedPages = 7;

    /** @var int */
    protected $edges = 1;

    /** @var array<int, mixed> */
    public $onChange;

    /**
     * @param string $templateType
     */
    public function render(string $templateType = 'default'): void
    {
        /** @var ITemplate $template */
        $template = $this->template;
        $template->setFile($this->getTemplateByType($templateType));

        $template->steps = $this->getSteps();
        $template->paginator = $this->getPaginator();
        $template->useAjax = $this->useAjax;

        $template->render();
    }

    /**
     * @param array<mixed, mixed> $params
     */
    public function loadState(array $params): void
    {
        parent::loadState($params);

        $this->getPaginator()->page = $this->page;
    }

    /**
     * @return array<int, mixed>
     */
    private function getSteps(): array
    {
        $paginator = $this->getPaginator();

        if ($paginator->pageCount < 2) {
            return [1];
        }

        $page = $paginator->page;
        $arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
        $count = 4;
        $quotient = ($paginator->pageCount - 1) / $count;
        for ($i = 0; $i <= $count; $i++) {
            $arr[] = (int) (round($quotient * $i) + $paginator->firstPage);
        }

        sort($arr);

        return array_values(array_unique($arr));
    }

    public function handleChange(): void
    {
        if ($this->useAjax) {
            $this->redrawControl('VisualPaginatorSnippet');
        }

        $this->onChange($this, $this->page);
    }

    public function enableAjax(): void
    {
        $this->useAjax = TRUE;
    }

    public function disableAjax(): void
    {
        $this->useAjax = FALSE;
    }

    /**
     * @return Paginator
     */
    public function getPaginator(): Paginator
    {
        if ($this->paginator === NULL) {
            $this->setPaginator(new Paginator());
        }

        return $this->paginator;
    }

    /**
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator): void
    {
        $this->paginator = $paginator;
    }

    /**
     * @return int
     */
    public function getDisplayedPages(): int
    {
        return $this->displayedPages;
    }

    /**
     * @param int $displayedPages
     */
    public function setDisplayedPages(int $displayedPages): void
    {
        if ($displayedPages < 3) {
            throw new InvalidArgumentException("Invalid argument 'displayedPages'. Argument must be equal to or greater than 3");
        }

        $this->displayedPages = $displayedPages;
    }

    /**
     * @return int
     */
    public function getEdges(): int
    {
        return $this->edges;
    }

    /**
     * @param int $edges
     */
    public function setEdges(int $edges): void
    {
        if ($edges < 1) {
            throw new InvalidArgumentException("Invalid argument 'edges'. Argument must be equal to or greater than 1");
        }

        $this->edges = $edges;
    }
}