<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('htdocs/wp')
    ->notPath('storage')
    ->notPath('vendor')
    ->notPath('node_modules')
    ->in(__DIR__)
    ->in(__DIR__.'/htdocs/wp-content/themes')
    ->notPath(__DIR__.'/htdocs/wp-content/themes/**/node_modules')
    ->name('*.php')
    ->name('_ide_helper')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config)
    ->setRules([
        '@PSR2'                                                               => true,
        'array_syntax'                                                        => ['syntax' => 'short'],
        'ordered_imports'        => [
            'sort_algorithm' => 'alpha',
        ],
        'no_unused_imports'                                                   => true,
        'not_operator_with_successor_space'                                   => true,
        'phpdoc_scalar'                                                       => true,
        'phpdoc_var_without_name'                                             => true,
        'phpdoc_single_line_var_spacing'                                      => true,
        'unary_operator_spaces'                                               => true,
        'phpdoc_trim'                                                         => true,
        'phpdoc_trim_consecutive_blank_line_separation'                       => true,
        'align_multiline_comment'                                             => true,
        'array_indentation'                                                   => true,
        'no_superfluous_elseif'                                               => true,
        'single_blank_line_before_namespace'                                  => true,
        'blank_line_after_opening_tag'                                        => true,
        'no_blank_lines_after_phpdoc'                                         => true,
        'phpdoc_separation'                                                   => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
            'operators' => [
                '=>' => null,
                '|' => 'no_space',
            ]
        ],
        'return_type_declaration' => [
            'space_before' => 'none',
        ],
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'full_opening_tag' => true,
        'method_argument_space' => [
            'on_multiline'                     => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ]
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
