<?php

declare(strict_types=1);

namespace App\config;

use Smarty\Smarty;

final class SmartyFactory
{
    public static function create(array $config, bool $debug): Smarty
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir($config['smarty']['template_dir']);
        $smarty->setCompileDir($config['smarty']['compile_dir']);
        $smarty->setCacheDir($config['smarty']['cache_dir']);
        $smarty->setDebugging($debug);

        return $smarty;
    }
}