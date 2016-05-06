<?php

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\CoreBundle\Test\HttpKernel\Bundle;

use Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle;
use Contao\CoreBundle\Test\TestCase;

/**
 * Tests the ContaoModuleBundle class.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class ContaoModuleBundleTest extends TestCase
{
    /**
     * @var ContaoModuleBundle
     */
    protected $bundle;

    /**
     * Creates a new Contao module bundle.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->bundle = new ContaoModuleBundle('foobar', $this->getRootDir().'/app');
    }

    /**
     * Tests the object instantiation.
     */
    public function testInstantiation()
    {
        $this->assertInstanceOf('Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle', $this->bundle);
    }

    /**
     * Tests the getPath() method.
     */
    public function testGetPath()
    {
        $this->assertEquals(
            $this->getRootDir().'/system/modules/foobar',
            $this->bundle->getPath()
        );
    }

    /**
     * Tests that an exception is thrown if the module folder does not exist.
     *
     * @expectedException \LogicException
     */
    public function testModuleFolderExists()
    {
        $this->bundle = new ContaoModuleBundle('invalid', $this->getRootDir().'/app');
    }
}
