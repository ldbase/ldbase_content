<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides an "LDbase Minimal Object Search Link Block" block.
 *
 * @Block(
 *   id="ldbase_minimal_object_search_link_block",
 *   admin_label = @Translation("LDbase Minimal Object Search Link Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseMinimalObjectSearchLinkBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<markup
<form action="/search" method="get" id="search-block-form" accept-charset="UTF-8">
  <input data-drupal-selector="edit-keys" type="search" id="edit-keys" name="keys" value="" class="search form-text" placeholder="search"/>
</form>
markup;
    return [
      '#markup' => Markup::create($content),
    ];
  }

}
