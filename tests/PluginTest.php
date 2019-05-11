<?php

namespace PaulCartSave\Tests;

use PaulCartSave\PaulCartSave as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'PaulCartSave' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['PaulCartSave'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
