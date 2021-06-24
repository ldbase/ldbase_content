<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block for D3 visualization of LDbase Content Counts.
 *
 * @Block (
 *   id = "ldbase_d3_content_count_block",
 *   admin_label = @Translation("LDbase Content Count D3 Visualization"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class LDbaseD3ContentCountBlock extends BlockBase {

  /**
   * @{inheritdoc}
   */
  public function build() {

    $render = [
      '#description' => '',
      '#attached' => [
        'library' => 'ldbase_content/d3_content_count_src'
      ],
      '#theme' => 'ldbase_d3_content_count_block',
    ];

    return $render;
  }

 }
