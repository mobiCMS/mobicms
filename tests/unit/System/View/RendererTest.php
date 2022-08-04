<?php

declare(strict_types=1);

namespace MobicmsTest\System\View;

use HttpSoft\Basis\TemplateRendererInterface;
use Mobicms\Render\Engine;
use Mobicms\System\View\Renderer;
use PHPUnit\Framework\TestCase;

class RendererTest extends TestCase
{
    private Renderer $renderer;

    public function setUp(): void
    {
        $this->renderer = new Renderer();
    }

    public function testCreateValidInstance(): void
    {
        $this->assertInstanceOf(Engine::class, $this->renderer);
        $this->assertInstanceOf(TemplateRendererInterface::class, $this->renderer);
    }

    public function testGetEngine()
    {
        $engine = $this->renderer->getEngine();
        $this->assertInstanceOf(Engine::class, $engine);
        $this->assertInstanceOf(TemplateRendererInterface::class, $engine);
    }
}
