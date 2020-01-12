<?php
namespace Morshadun\RepositoryPattern\Tests;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;

class DesignPatternCommandTest extends TestCase
{
    /**
        @test
     */

    public function new_controller_is_created()
    {
        Artisan::command('morshadun:controller', function () {
            $name = 'TestController';

            $this->seeInConsoleOutput('controller created successfully');

        });

    }

    protected function seeInConsoleOutput($expectedText)
    {
        $consoleOutput = $this->app[Kernel::class]->output();
        $this->assertStringContainsString($expectedText, $consoleOutput,
            "Did not see `{$expectedText}` in console output: `$consoleOutput`");
    }
}
