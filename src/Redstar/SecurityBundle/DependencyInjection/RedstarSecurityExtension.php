<?php

namespace Redstar\SecurityBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RedstarSecurityExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    
    private $container;
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->container = $container;
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $this->loadConfig($config);
        
    }
    
    private function loadConfig($config)
    {
        foreach($config as $key => $val){
            if(!is_array($val))
            {
               $this->container->setParameter('redstar_security.' .  $key , $val);
            }
            else
            {
               $this->loadConfigArray($key, $val);
            }
        }
    }
    
    private function loadConfigArray($key, $config)
    {
        $keyArray = $key;
        foreach($config as $key => $val)
        {
            if(is_array($val))
            {
                $keyArray .= '.' . $key;
                $this->loadConfigArray($keyArray,$val);
            }
            $this->container->setParameter('redstar_security.' . $keyArray . '.' . $key, $val);
        }
    }
}