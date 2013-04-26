<?php
namespace JustLess\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\Glob;

/**
 * @author Rick <contact@rickkuipers.com>
 * @company Rick Kuipers Development
 */
class Less extends AbstractHelper
{
    protected $sm;

    public function __construct($sm) {
        $this->sm = $sm;
    }

    public function __invoke($file, $minify = null)
    {
        if (!is_file($this->getOptions()->getPublicDir() . $file)) {
            throw new \InvalidArgumentException('File "' . $this->getOptions()->getPublicDir() . $file . '" not found.');
        }
        $less = new \lessc();
        $info = pathinfo($file);
        $newFile = $this->getOptions()->getDestinationDir() . $info['filename'] . '.' . filemtime($this->getOptions()->getPublicDir() . $file) . '.css';
        $_file = $this->getOptions()->getPublicDir() . $newFile;
        if (!is_file($_file)) {
            $globPattern = $this->getOptions()->getPublicDir() . $this->getOptions()->getDestinationDir() . $info['filename'] . '.*.css';
            foreach (Glob::glob($globPattern, Glob::GLOB_BRACE) as $match) {
                if (preg_match("/^" . $info['filename'] . "\.[0-9]{10}\.css$/", basename($match))) {
                    unlink($match);
                }
            }
            $compiledFile = new \SplFileObject($_file, 'w');
            $result = $less->compileFile($this->getOptions()->getPublicDir() . $file);
            if ((is_null($minify) && $this->getOptions()->getMinify()) || $minify === true) {
                $result = \CssMin::minify($result);
            }
            $compiledFile->fwrite($result);
        }
        return $newFile;
    }

    protected function getServiceLocator() {
        return $this->sm->getServiceLocator();
    }

    /**
     * @return \JustLess\Options\ModuleOptions
     */
    protected function getOptions() {
        return $this->getServiceLocator()->get('JustLess\Options\ModuleOptions');
    }
}
