<?php

<<<<<<< HEAD:src/Brouwkuyp/Bundle/ServiceBundle/DependencyInjection/Configuration.php
namespace Brouwkuyp\Bundle\ServiceBundle\DependencyInjection;
=======
namespace Brouwkuyp\Bundle\BrewBundle\DependencyInjection;
>>>>>>> Renamed bundle namespaces:src/Brouwkuyp/Bundle/BrewBundle/DependencyInjection/Configuration.php

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
<<<<<<< HEAD:src/Brouwkuyp/Bundle/ServiceBundle/DependencyInjection/Configuration.php
        $rootNode = $treeBuilder->root('brouwkuyp_service');
=======
        $rootNode = $treeBuilder->root('brouwkuyp_brew');
>>>>>>> Added DashboardBundle:src/Brouwkuyp/Bundle/BrewBundle/DependencyInjection/Configuration.php

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        return $treeBuilder;
    }
}
