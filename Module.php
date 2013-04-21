<?php

namespace JustLess;

use Zend\Loader;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

/**
 * @author Rick <contact@rickkuipers.com>
 * @company Rick Kuipers Development
 */
class Module implements
    ConfigProviderInterface,
    AutoloaderProviderInterface
{

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            Loader\AutoloaderFactory::STANDARD_AUTOLOADER => array(
                Loader\StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'JustLess\Options\ModuleOptions' => function($sm) {
                    $config = $sm->get('Config');
                    return new \JustLess\Options\ModuleOptions($config['justless']);
                }
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'less' => function($sm) {
                    return new \JustLess\View\Helper\Less($sm);
                }
            ),
        );
    }
}
