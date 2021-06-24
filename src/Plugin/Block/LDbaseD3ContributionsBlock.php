<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block for D3 visualization of LDbase contributions.
 *
 * @Block (
 *   id = "ldbase_d3_contributions_block",
 *   admin_label = @Translation("LDbase Contributions D3 Visualization"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class LDbaseD3ContributionsBlock extends BlockBase {

  /**
   * @{inheritdoc}
   */
  public function build() {
    $top_text = 'The larger, blue circles represent investgators. The smaller circles represent the projects, datasets, code, and documents they have contributed. Mouseover tooltips on the circles display the type and name.';

    $render = [
      '#description' => $this->t($top_text),
      '#attached' => [
        'library' => 'ldbase_content/d3_contributions_src'
      ],
      '#theme' => 'ldbase_d3_contributions_block',
    ];

    return $render;
  }

 }
