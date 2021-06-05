<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/app')
    ->exclude('vendor')
    ->notPath('#/Controllers/#')
    ->notPath('#/Fixtures/#')
    ->append([
        __DIR__.'/dev-tools/doc.php',
    ])
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP71Migration' => true,
        '@PHPUnit75Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'no_useless_return' => true,
        'no_useless_else' => true,
        'single_quote' => true,
        'no_unused_imports' => true,
        'no_empty_statement' => true,
        'no_superfluous_phpdoc_tags' => false,
        'combine_consecutive_unsets' => true,
        'phpdoc_to_return_type' => true,
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'ordered_imports' => [
            'imports_order' => [
                'class', 'function', 'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'function_typehint_space' => true,
        'single_trait_insert_per_statement' => true,
        'native_constant_invocation' => [
            'exclude' => ['null', 'false', 'true']
        ],
        'native_function_invocation' => [
            'include' => ['@internal', '@compiler_optimized', '@all']
        ],
        'blank_line_before_statement' => true,
        'void_return' => true
    ])
    ->setFinder($finder)
;

// special handling of fabbot.io service if it's using too old PHP CS Fixer version
if (false !== getenv('FABBOT_IO')) {
    try {
        PhpCsFixer\FixerFactory::create()
            ->registerBuiltInFixers()
            ->registerCustomFixers($config->getCustomFixers())
            ->useRuleSet(new PhpCsFixer\RuleSet($config->getRules()))
        ;
    } catch (PhpCsFixer\ConfigurationException\InvalidConfigurationException $e) {
        $config->setRules([]);
    } catch (UnexpectedValueException $e) {
        $config->setRules([]);
    } catch (InvalidArgumentException $e) {
        $config->setRules([]);
    }
}

return $config;
