<?php

declare(strict_types=1);

namespace Mobicms\System\View;

use HttpSoft\Basis\TemplateRendererInterface;
use Mobicms\Render\Engine;

class Renderer extends Engine implements TemplateRendererInterface
{
    public function getEngine(): object
    {
        return $this;
    }
}
