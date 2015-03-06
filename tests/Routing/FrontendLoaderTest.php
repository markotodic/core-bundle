<?php

/**
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\Test\Routing;

use Contao\CoreBundle\Routing\FrontendLoader;

/**
 * Tests the FrontendLoader class.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class FrontendLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the object instantiation.
     */
    public function testInstantiation()
    {
        $loader = new FrontendLoader(false, '');

        $this->assertInstanceOf('Contao\CoreBundle\Routing\FrontendLoader', $loader);
    }

    /**
     * Tests with URL suffix and without language.
     */
    public function testLoadWithoutLanguage()
    {
        $loader     = new FrontendLoader(false, '.html', 'en');
        $collection = $loader->load('.', 'bundles');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $routes = $collection->all();

        $this->assertArrayHasKey('contao_frontend', $routes);
        $this->assertEquals('/{alias}.{_format}', $routes['contao_frontend']->getPath());
        $this->assertEquals('ContaoCoreBundle:Frontend:index', $routes['contao_frontend']->getDefault('_controller'));
        $this->assertEquals('html', $routes['contao_frontend']->getDefault('_format'));
        $this->assertEquals('.*', $routes['contao_frontend']->getRequirement('alias'));
        $this->assertEquals('html', $routes['contao_frontend']->getRequirement('_format'));
        $this->assertEquals('', $routes['contao_frontend']->getRequirement('_locale'));
    }

    /**
     * Tests with URL suffix and with language.
     */
    public function testLoadWitLanguage()
    {
        $loader     = new FrontendLoader(true, '.html', 'en');
        $collection = $loader->load('.', 'bundles');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $routes = $collection->all();

        $this->assertArrayHasKey('contao_frontend', $routes);
        $this->assertEquals('/{_locale}/{alias}.{_format}', $routes['contao_frontend']->getPath());
        $this->assertEquals('ContaoCoreBundle:Frontend:index', $routes['contao_frontend']->getDefault('_controller'));
        $this->assertEquals('html', $routes['contao_frontend']->getDefault('_format'));
        $this->assertEquals('.*', $routes['contao_frontend']->getRequirement('alias'));
        $this->assertEquals('html', $routes['contao_frontend']->getRequirement('_format'));
        $this->assertEquals('[a-z]{2}(\-[A-Z]{2})?', $routes['contao_frontend']->getRequirement('_locale'));
    }

    /**
     * Tests without URL suffix and without language.
     */
    public function testLoadWithoutLanguageAndWithoutSuffix()
    {
        $loader     = new FrontendLoader(false, '', 'en');
        $collection = $loader->load('.', 'bundles');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $routes = $collection->all();

        $this->assertArrayHasKey('contao_frontend', $routes);
        $this->assertEquals('/{alias}', $routes['contao_frontend']->getPath());
        $this->assertEquals('ContaoCoreBundle:Frontend:index', $routes['contao_frontend']->getDefault('_controller'));
        $this->assertEquals('', $routes['contao_frontend']->getDefault('_format'));
        $this->assertEquals('.*', $routes['contao_frontend']->getRequirement('alias'));
        $this->assertEquals('', $routes['contao_frontend']->getRequirement('_format'));
        $this->assertEquals('', $routes['contao_frontend']->getRequirement('_locale'));
    }

    /**
     * Tests without URL suffix and with language.
     */
    public function testLoadWithLanguageAndWithoutSuffix()
    {
        $loader     = new FrontendLoader(true, '', 'en');
        $collection = $loader->load('.', 'bundles');

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $routes = $collection->all();

        $this->assertArrayHasKey('contao_frontend', $routes);
        $this->assertEquals('/{_locale}/{alias}', $routes['contao_frontend']->getPath());
        $this->assertEquals('ContaoCoreBundle:Frontend:index', $routes['contao_frontend']->getDefault('_controller'));
        $this->assertEquals('', $routes['contao_frontend']->getDefault('_format'));
        $this->assertEquals('.*', $routes['contao_frontend']->getRequirement('alias'));
        $this->assertEquals('', $routes['contao_frontend']->getRequirement('_format'));
        $this->assertEquals('[a-z]{2}(\-[A-Z]{2})?', $routes['contao_frontend']->getRequirement('_locale'));
    }

    /**
     * Ensures that the loader supports "bundles".
     */
    public function testSupportsContaoFrontend()
    {
        $loader = new FrontendLoader(false, '', 'en');

        $this->assertTrue($loader->supports('.', 'bundles'));
    }
}
