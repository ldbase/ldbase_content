<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Search Data Button" block.
 *
 * @Block(
 *   id="search_data_button",
 *   admin_label = @Translation("Search Data Button"),
 *   category = @Translation("LDbase Block")
 * )
 */
class SearchDataButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $page_url = 'search?search_api_fulltext=&search_api_full_text_1=';
    return [
      '#markup' => $this->t("<div id=\"search-data-button\"><a class=\"button\" href=\"{$page_url}\">Search Data</a></div>"),
    ];
  }
}
