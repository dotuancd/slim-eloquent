<?php

namespace App;

use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Symfony\Component\Finder\Finder;
use Illuminate\Config\Repository as Config;
use Illuminate\Database\DatabaseServiceProvider;

class Bootstrap
{
    protected $container;
    protected $booted = false;
    
    protected $services = [
        DatabaseServiceProvider::class,
        EventServiceProvider::class,
    ];
    
    public function boot()
    {
        if ($this->booted) {
            return false;
        }
        
        $this->container = $container = new Container();
        $this->loadConfig(__DIR__ . '/../config', $container);
        $this->registerServices($container);
        $this->bootServices($container);
    }
    
    /**
     * @param $container
     */
    protected function registerServices($container)
    {
        foreach ($this->services as $providerClass) {
            $provider = new $providerClass($container);
            $provider->register();
        }
    }
    
    /**
     * @param $directory
     * @param $container
     */
    protected function loadConfig($directory, $container)
    {
        $loader = Finder::create();
        $loader->files()->name('*.php')->in($directory);
    
        $config = new Config();
        $configFiles = $loader->getIterator();
    
        foreach($configFiles as $key => $file) {
            $key = basename($file->getRealPath(), '.php');
            $config->set($key, require($file->getRealPath()));
        }
        
        $container->instance('config', $config);
    }
    
    protected function bootServices($container)
    {
//        \Illuminate\Database\Eloquent\Model::setConnectionResolver($container['db']);
    }
}
