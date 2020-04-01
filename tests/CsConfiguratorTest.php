<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/common-dev-extra created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file LICENSE which is
 * distributed with this source code. For more information, see <https://opensource.gpupo.com/>
 */

namespace Gpupo\CommonDevExtra\Tests\Traits;

use Gpupo\CommonDevExtra\CsConfigurator;
use Gpupo\CommonDevExtra\Tests\TestCaseAbstract;

/**
 * @coversNothing
 */
class CsConfiguratorTest extends TestCaseAbstract
{
    public function testGetConfig()
    {
        $packageInfo = [
            'project' => 'foo/bar',
            'author' => 'Outer Bass <my@basses.com>',
            'url' => 'https://basses.com/',
        ];

        $config = (new CsConfigurator(__DIR__))->getConfig($packageInfo);
        $this->assertTrue($config->getRules()['@PHP56Migration']);

        foreach ($packageInfo as $k => $v) {
            $this->assertStringContainsString($v, current($config->getRules()['header_comment']));
        }
    }

    public function testCustomTemplate()
    {
        $packageInfo = [
            'header' => 'I got You',
        ];

        $config = (new CsConfigurator(__DIR__))->getConfig($packageInfo);
        $this->assertSame('I got You', current($config->getRules()['header_comment']));
    }

    public function testWhithoutParameters()
    {
        $config = (new CsConfigurator(__DIR__))->getConfig();
        $this->assertStringContainsString('UNDEFINED', current($config->getRules()['header_comment']));
    }
}
