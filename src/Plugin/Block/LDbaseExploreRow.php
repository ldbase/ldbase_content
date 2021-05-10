<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block with a row of explore liks.
 *
 * @Block(
 *   id="ldbase_explore_row",
 *   admin_label = @Translation("LDbase Explore Links Row"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseExploreRow extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<EOM
<div class="browse-link-row d-flex flex-row justify-content-around flex-wrap">
  <div class="link-block" id="block-1">
  <img src="/modules/custom/ldbase_content/images/bookshelf.svg" alt="bookshelf icon">
  <h3>Browse Data</h3>
  <p><a class="link-div" href="/browse-data">See what's in LDbase</a></p>
  </div>

  <div class="link-block" id="block-2">
  <img src="/modules/custom/ldbase_content/images/signpost-2.svg" alt="signpost icon">
  <h3>Resources</h3>
  <p><a href="/resources">Learn about good data practices</a></p>
  </div>

  <div class="link-block" id="block-3">
  <img src="/modules/custom/ldbase_content/images/binoculars-fill.svg" alt="binoculars icon">
  <h3>Search</h3>
  <p><a href="/search?search_api_fulltext=">Find something specific</a></p>
  </div>

  <div class="link-block" id="block-4">
  <img src="/modules/custom/ldbase_content/images/layout-text-window-reverse.svg" alt="form page icon">
  <h3>Add Data</h3>
  <p><a href="/add-project">Add your project to LDbase</a></p>
  </div>
</div>
EOM;

    return [
      '#markup' => $content,
      '#allowed_tags' => ['div','a','p','h3','img'],
    ];
  }
}
