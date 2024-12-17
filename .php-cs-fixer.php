<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$config = new Config();
return $config
  ->setRules([
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => true,
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => [
      'statements' => ['return']
    ],
    'braces' => true,
    'cast_spaces' => true,
    'class_attributes_separation' => [
      'elements' => ['method' => 'one']
    ],
    'class_definition' => true,
    'concat_space' => [
      'spacing' => 'none'
    ],
    'declare_equal_normalize' => true,
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'single_line_comment_style' => [
      'comment_types' => ['hash']
    ],
    'heredoc_to_nowdoc' => true,
    'include' => true,
    'indentation_type' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'list_syntax' => ['syntax' => 'short'],
    'lowercase_cast' => true,
    'constant_case' => ['case' => 'lower'],  // lowercase_constants の代わり
    'lowercase_keywords' => true,
    'magic_constant_casing' => true,
    'method_argument_space' => true,
    'native_function_casing' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_closing_tag' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_mixed_echo_print' => [
      'use' => 'echo'
    ],
    'no_multiline_whitespace_around_double_arrow' => true,
    'multiline_whitespace_before_semicolons' => [
      'strategy' => 'no_multi_line'
    ],
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_around_offset' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_singleline' => true,  // no_trailing_comma_in_list_call の代わり
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,
    'phpdoc_indent' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'simplified_null_return' => false,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'single_class_element_per_statement' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'ternary_operator_spaces' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => [
      'elements' => ['method', 'property']
    ],
    'whitespace_after_comma_in_array' => true,
  ])
  ->setIndent("  ") // 2スペースのインデント
  ->setLineEnding("\n")
  ->setFinder(
    Finder::create()
      ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    __DIR__ . '/public',
        __DIR__ . '/bootstrap',

      ])
      ->name('*.php')
      ->notName('*.blade.php')
      ->ignoreDotFiles(true)
      ->ignoreVCS(true)
  );
