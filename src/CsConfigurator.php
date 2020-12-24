<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/common-dev-extra created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file LICENSE which is
 * distributed with this source code. For more information, see <https://opensource.gpupo.com/>
 */

namespace Gpupo\CommonDevExtra;

use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

class CsConfigurator
{
    protected const DEFAULT_RULES = [
        '@PHP80Migration' => true,
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
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'multiline_comment_opening_closing' => true,
        'no_extra_blank_lines' => ['tokens' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block']],
        'no_null_property_initialization' => true,
        'echo_tag_syntax' => true,
        'no_superfluous_elseif' => true,
        'no_unneeded_curly_braces' => true,
        'no_unneeded_final_method' => true,
        'no_unreachable_default_argument_value' => true,
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
        'fully_qualified_strict_types' => true,
        'constant_case' => true,
        'no_superfluous_elseif' => true,
    ];

    private array $config;

    private string $template = <<<'EOF'
        This file is part of %s created by %s
        For the information of copyright and license you should read the file LICENSE which is
        distributed with this source code. For more information, see <%s>
        EOF;

    public function __construct(
        protected string $directory,
        protected Finder | null $finder = null,
        protected array $rules = [],
        protected bool $usingCache = true,
    ) {
    }

    public function getRules(): array
    {
        if (empty($this->rules)) {
            $this->rules = self::DEFAULT_RULES;
        }

        return $this->rules;
    }

    public function addRules(array $rules): self
    {
        $this->rules = array_merge($this->getRules(), $rules);

        return $this;
    }

    public function getFinder(): Finder
    {
        if (empty($this->finder)) {
            $this->finder = $this->factoryFinder($this->directory);
        }

        return $this->finder;
    }

    public function getConfig(array $params = []): ConfigInterface
    {
        $rules = $this->getRules();
        if (!\array_key_exists('header', $params)) {
            $vars = [];

            foreach (['project', 'author', 'url'] as $k) {
                $vars[$k] = \array_key_exists($k, $params) ? $params[$k] : 'UNDEFINED';
            }

            if (!\array_key_exists('template', $params)) {
                $params['template'] = $this->template;
            }

            $params['header'] = vsprintf($params['template'], $vars);
        }

        $rules['header_comment']['header'] = $params['header'];

        return (new Config())
            ->setRiskyAllowed(true)
            ->setRules($rules)
            ->setFinder($this->getFinder())
            ->setUsingCache($this->usingCache)
        ;
    }

    protected function factoryFinder(string $directory): Finder
    {
        return (new Finder())
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
