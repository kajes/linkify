<?php

$header = <<<EOF
This file is part of Yrgo.

(c) Yrgo, högre yrkesutbildning.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$rules = [
    // PSR-0
    'psr0' => false,

    // PSR-1
    '@PSR1' => true,

    // PSR-2
    '@PSR2' => true,

    // PSR-4
    'psr4' => true,

    // Symfony
    'binary_operator_spaces' => ['align_double_arrow' => false, 'align_equals' => false],
    'blank_line_after_opening_tag' => true,
    'blank_line_before_return' => true,
    'cast_spaces' => true,
    'concat_space' => ['spacing' => 'none'],
    'function_typehint_space' => true,
    'hash_to_slash_comment' => true,
    'include' => true,
    'lowercase_cast' => true,
    'new_with_braces' => true,
    'no_alias_functions' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines' => ['use'],
    'no_extra_consecutive_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_mixed_echo_print' => ['use' => 'echo'],
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unused_imports' => true,
    'no_whitespace_in_blank_line' => true,
    'object_operator_without_whitespace' => true,
    'phpdoc_indent' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_alias_tag' => ['type' => 'var'],
    'phpdoc_no_package' => true,
    'phpdoc_scalar' => true,
    'phpdoc_separation' => true,
    'phpdoc_summary' => true,
    'phpdoc_to_comment' => true,
    'phpdoc_trim' => true,
    'phpdoc_var_without_name' => true,
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'simplified_null_return' => true,
    'single_blank_line_before_namespace' => true,
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'whitespace_after_comma_in_array' => true,

    // Contrib
    'array_syntax' => ['syntax' => 'short'],
    'header_comment' => ['header' => $header, 'location' => 'after_open'],
    'linebreak_after_opening_tag' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_short_echo_tag' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'ordered_imports' => true,
    'php_unit_construct' => true,
    'php_unit_dedicate_assert' => true,
    'php_unit_strict' => true,
    'phpdoc_order' => true,
];

$directories = [
  'node_modules',
  'public/languages',
  'public/mu-plugins',
  'public/plugins',
  'public/upgrade',
  'public/uploads',
  'public/wordpress',
  'resources',
  'vendor',
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($directories)
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder($finder);
