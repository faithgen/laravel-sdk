<?php

namespace FaithGen\SDK\Feature;


use Orchestra\Testbench\TestCase;

class ComposerTest extends TestCase
{

    /**
     * @test
     */
    public function is_composer_setup_correct()
    {
        $composerData = json_decode(file_get_contents(__DIR__.'/../../composer.json'));

        $this->assertFalse($composerData->name == 'faithgen/sdkk');
        $this->assertTrue($composerData->name == 'faithgen/sdk');

        $this->assertArrayHasKey('homepage', (array) $composerData);

        $this->assertEquals($composerData->homepage, 'https://github.com/faithgen/laravel-sdk');

        $this->assertArrayNotHasKey('damnit', (array) $composerData);

        $providers = $composerData->extra->laravel->providers;

        $this->assertCount(3, $providers);
    }
}
