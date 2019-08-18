# Visual paginator

-----

[![Build Status](https://travis-ci.org/surda/visual-paginator.svg?branch=master)](https://travis-ci.org/surda/visual-paginator)
[![Licence](https://img.shields.io/packagist/l/surda/visual-paginator.svg?style=flat-square)](https://packagist.org/packages/surda/visual-paginator)
[![Latest stable](https://img.shields.io/packagist/v/surda/visual-paginator.svg?style=flat-square)](https://packagist.org/packages/surda/visual-paginator)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)


## Installation

The recommended way to is via Composer:

```
composer require surda/visual-paginator
```

After that you have to register extension in config.neon:

```yaml
extensions:
    visualPaginator: Surda\VisualPaginator\VisualPaginatorExtension
```

## Configuration

Default
```yaml
visualPaginator:
    edges: 1
    displayedPages: 7
    useAjax: FALSE
    templates:
        default: bootstrap4.default.latte
        default-ajax: bootstrap4.default.ajax.latte
        mini: bootstrap4.mini.latte
```

## Usage

Presenter

```php
use Surda\VisualPaginator\TVisualPaginator;
use Surda\VisualPaginator\VisualPaginatorControl;
use Nette\Utils\Paginator;

class ProductPresenter extends Nette\Application\UI\Presenter
{
    use TVisualPaginator;

    public function actionDefault(): void
    {
        /** @var VisualPaginatorControl $ipp */
        $ipp = $this->getComponent('ipp');

        /** @var Paginator $paginator */
        $paginator = $vp->getPaginator();
        $paginator->setItemsPerPage(20);
        $paginator->setItemCount(500);

        // $rows->limit($paginator->getItemsPerPage(), $paginator->getOffset());
    }
}
```
Template

```html
{control vp} or {control vp default} 
```

## Custom options

```php
class ProductPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @return VisualPaginatorControl
     */
    protected function createComponentIpp(): VisualPaginatorControl
    {
        $control = $this->visualPaginatorFactory->create();

        $control->setEdges(1);
        $control->setDisplayedPages(7);
        $control->disableAjax();
        $control->enableAjax();

        return $control;
    }
}
```