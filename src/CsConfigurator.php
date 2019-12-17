<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/common-dev-extra
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://opensource.gpupo.com/>.
 *
 */

namespace Gpupo\CommonDevExtra;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

class CsConfigurator
{
    protected $default_rules = [
        '@PHP56Migration' => true,
        '@PHPUnit60Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'align_multiline_comment' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_typehint' => true,
        'escape_implicit_backslashes' => true,
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'declare_strict_types' => true,
        'final_internal_class' => true,
        'heredoc_to_nowdoc' => true,
        'list_syntax' => ['syntax' => 'long'],
        'method_chaining_indentation' => true,
        'method_argument_space' => ['ensure_fully_multiline' => true],
        'multiline_comment_opening_closing' => true,
        'no_extra_blank_lines' => ['tokens' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block']],
        'no_null_property_initialization' => true,
        'no_short_echo_tag' => true,
        'no_superfluous_elseif' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_strict' => true,
        'php_unit_test_annotation' => true,
        'php_unit_test_class_requires_covers' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
        'phpdoc_types_order' => true,
        'semicolon_after_instruction' => true,
        'single_line_comment_style' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'yoda_style' => true,
        'mb_str_functions' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced'],
    ];

    private $config;

    private $template = <<<'EOF'
This file is part of %s
Created by %s
For the information of copyright and license you should read the file
LICENSE which is distributed with this source code.
Para a informação dos direitos autorais e de licença você deve ler o arquivo
LICENSE que é distribuído com este código-fonte.
Para obtener la información de los derechos de autor y la licencia debe leer
el archivo LICENSE que se distribuye con el código fuente.
For more information, see <%s>.

EOF;

    public function __construct($directory, Finder $finder = null, $rules = null, $usingCache = true)
    {
        if (empty($finder)) {
            $finder = $this->factoryFinder($directory);
        }

        if (empty($rules)) {
            $rules = $this->default_rules;
        }

        $this->config = [
            'directory' => $directory,
            'finder' => $finder,
            'rules' => $rules,
            'usingCache' => $usingCache,
        ];

    }

    public function getConfig(array $params): ?Config
    {
        $rules = $this->config['rules'];
        $header = sprintf($this->template, $params['project'], $params['author'], $params['url']);
        $rules['header_comment']['header'] = $header;

        return Config::create()
            ->setRiskyAllowed(true)
            ->setRules($rules)
            ->setFinder($this->config['finder'])
            ->setUsingCache($this->config['usingCache'])
        ;
    }

    protected function factoryFinder($directory)
    {
        return Finder::create()
            ->notName('LICENSE')
            ->notName('README.md')
            ->notName('phpunit.xml*')
            ->notName('*.phar')
            ->exclude('vendor')
            ->exclude('var')
            ->exclude('.phan')
            ->exclude('Resources')
            ->exclude('tests/Fixtures')
            ->in($directory);
    }
}
