<?php
namespace Tbtbt\Phalcon\Mvc\View\Engine;

use Phalcon\Mvc\View\Engine;
use Phalcon\Mvc\View\EngineInterface;

/**
 * Phalcon\MVC\View\Engine\PHPTAL
 *
 * Adapter to use PHPTAL library as templating engine
 */
class PhpTal extends Engine implements EngineInterface
{
    /**
     * @var \PHPTAL
     */
    private $phptal;

    /**
     * {@inheritdoc}
     *
     * @param \Phalcon\Mvc\ViewInterface
     * @param \Phalcon\DiInterface
     * @param \PHPTAL
     */
    public function __construct($view, \Phalcon\DiInterface $di = null, \PHPTAL $phptal = null)
    {
        if ($phptal !== null) {
            $this->phptal = $phptal;
        }

        parent::__construct($view, $di);
    }

    /**
     * {@inheritdoc}
     *
     * @param string  $path
     * @param array   $params
     * @param boolean $mustClean
     */
    public function render($path, $params, $mustClean = false)
    {
        if ($this->phptal === null) {
            throw new \RuntimeException('PHTAL is not set.');
        }

        if (!isset($params['content'])) {
            $params['content'] = $this->_view->getContent();
        }

        foreach ($params as $name => $value) {
            $this->phptal->set($name, $value);
        }

        $content = $this->phptal->setTemplate($path)->execute();
        if ($mustClean) {
            $this->_view->setContent($content);
        } else {
            echo $content;
        }
    }

    /**
     * Set PHPTAL
     *
     * @param \PHPTAL
     */
    public function setPhpTal(\PHPTAL $phptal)
    {
        $this->phptal = $phptal;
    }
}