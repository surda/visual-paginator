<?php declare(strict_types=1);

namespace Surda\VisualPaginator\DI;

use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Surda\VisualPaginator\VisualPaginatorFactory;

class VisualPaginatorExtension extends CompilerExtension
{
    /** @var array */
    private $templates = [
        'default' => __DIR__ . '/../Templates/bootstrap4.default.latte',
        'default-ajax' => __DIR__ . '/../Templates/bootstrap4.default.ajax.latte',
        'mini' => __DIR__ . '/../Templates/bootstrap4.mini.latte',
    ];

    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            'edges' => Expect::int()->default(1),
            'displayedPages' => Expect::int()->default(7),
            'useAjax' => Expect::bool(FALSE),
            'template' => Expect::string()->nullable()->default(NULL),
            'templates' => Expect::array()->default([]),
        ]);
    }

    public function loadConfiguration(): void
    {
        $builder = $this->getContainerBuilder();
        $config = $this->config;

        $visualPaginatorFactory = $builder->addFactoryDefinition($this->prefix('factory'))
            ->setImplement(VisualPaginatorFactory::class);

        $visualPaginatorDefinition = $visualPaginatorFactory->getResultDefinition();

        $visualPaginatorDefinition->addSetup('setEdges', [$config->edges]);
        $visualPaginatorDefinition->addSetup('setDisplayedPages', [$config->displayedPages]);
        $visualPaginatorDefinition->addSetup($config->useAjax === TRUE ? 'enableAjax' : 'disableAjax');

        $templates = $config->templates === [] ? $this->templates : $config->templates;

        foreach ($templates as $type => $templateFile) {
            $visualPaginatorDefinition->addSetup('setTemplateByType', [$type, $templateFile]);
        }

        if ($config->template !== NULL) {
            $visualPaginatorDefinition->addSetup('setTemplate', [$config->template]);
        }
    }
}