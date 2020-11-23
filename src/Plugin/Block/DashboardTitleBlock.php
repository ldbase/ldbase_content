<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "My Dashboard Title" block.
 *
 * @Block(
 *   id="my_dashboard_title",
 *   admin_label = @Translation("My Dashboard Title"),
 *   category = @Translation("LDbase Block")
 * )
 */
class DashboardTitleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t("<h1>My Dashboard</h1>"),
    ];
  }
}
