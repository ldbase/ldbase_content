<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Browse Data Button" block.
 *
 * @Block(
 *   id="browse_data_button",
 *   admin_label = @Translation("Browse Data Button"),
 *   category = @Translation("LDbase Block")
 * )
 */
class BrowseDataButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $page_url = '/browse-data';
    return [
      '#markup' => $this->t("<div id=\"browse-data-button\"><a class=\"button\" href=\"{$page_url}\">Browse Data</a></div>"),
    ];
  }
}
