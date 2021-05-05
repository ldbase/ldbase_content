<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Learn About Data Practices  Button" block.
 *
 * @Block(
 *   id="data_resources_button",
 *   admin_label = @Translation("Learn About Data Practices Button"),
 *   category = @Translation("LDbase Block")
 * )
 */
class DataResourcesButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $page_url = '/resources';
    return [
      '#markup' => $this->t("<div id=\"data-resources-button\"><a class=\"button\" href=\"{$page_url}\">Learn About Data Practices</a></div>"),
    ];
  }
}
