<?php

namespace FaithGen\SDK\Feature;

use Orchestra\Testbench\TestCase;

class FilesTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_storage_files()
    {
        $this->assertDirectoryExists(__DIR__.'/../../storage', 'Create the storage dir');
        $this->assertDirectoryExists(__DIR__.'/../../storage/logo', 'Create the logo dir inside of storage');
        $this->assertDirectoryExists(__DIR__.'/../../storage/users', 'Create a users dir inside of storage');
        $this->assertDirectoryExists(__DIR__.'/../../storage/profile');
    }

    /**
     * @test
     */
    public function it_has_logo()
    {
        $this->assertFileExists(__DIR__.'/../../storage/logo/logo-50.png');
        $this->assertFileExists(__DIR__.'/../../storage/logo/logo-100.png');
        $this->assertFileExists(__DIR__.'/../../storage/logo/logo-original.png');
    }

    /**
     * @test
     */
    public function it_profiles_dir_ready()
    {
        $this->assertFileExists(__DIR__.'/../../storage/profile/50-50/.gitignore');
        $this->assertFileExists(__DIR__.'/../../storage/profile/100-100/.gitignore');
        $this->assertFileExists(__DIR__.'/../../storage/profile/original/.gitignore');
    }

    /**
     * @test
     */
    public function it_users_dir_ready()
    {
        $this->assertFileExists(__DIR__.'/../../storage/users/50-50/.gitignore');
        $this->assertFileExists(__DIR__.'/../../storage/users/original/.gitignore');
    }
}
