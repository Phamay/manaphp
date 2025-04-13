<?php

declare(strict_types=1);

namespace App\Commands;

use ManaPHP\Cli\Command;
use ManaPHP\Helper\LocalFS;
use function array_diff;
use function array_intersect;
use function array_merge;
use function array_unique;
use function count;
use function file_get_contents;
use function get_defined_functions;
use function preg_match_all;
use function realpath;
use function sort;
use function str_ends_with;
use function substr;

/**
 * native_function_invocation
 */
class NativeFunctionInvocationCommand extends Command
{
    public function defaultAction($dir = '.'): void
    {
        $real_dir = realpath($dir);

        $defined_functions = get_defined_functions();
        $all_functions = array_merge($defined_functions['internal'], $defined_functions['user']);

        foreach (LocalFS::glob($real_dir . '/**/*.php') as $file) {
            if (str_ends_with($file, 'Interface.php')) {
                continue;
            }

            $content = file_get_contents($file);
            $used_functions = preg_match_all('#use\s+function\s+(\w+)\s*;#', $content, $matches) ? $matches[1] : [];

            #             $called_functions = preg_match_all('#(?<!function |new|::|->)(\w+)\s*\\(#', $content, $matches)

            $called_functions = preg_match_all('#(\w+)\s*\\(#', $content, $matches)
                ? array_unique($matches[1]) : [];

            $unused_functions = array_diff(
                $called_functions, $used_functions, ['make', 'bootstrap', 'header', 'exec', 'glob', 'log']
            );
            $unused_functions = array_intersect($unused_functions, $all_functions);
            sort($unused_functions);

            if (count($unused_functions) === 0) {
                continue;
            }

            $this->console->writeLn(substr($file, 0));
            foreach ($unused_functions as $unused_function) {
                $this->console->writeLn('use function ' . $unused_function . ';');
            }
            $this->console->writeLn();
        }
    }
}