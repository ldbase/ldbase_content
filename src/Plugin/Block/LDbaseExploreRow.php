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
<a class="link-div" href="/browse-data">
 <div class="link-block" id="block-1">
  <img src="/modules/custom/ldbase_content/images/bookshelf.svg" alt="bookshelf icon">
  <h3 class="link-block-header">Browse Data</h3>
  <p>See what's in LDbase</p>
  </div>
</a>
<a class="link-div" href="/resources">
  <div class="link-block" id="block-2">
  <img src="/modules/custom/ldbase_content/images/signpost-2.svg" alt="signpost icon">
  <h3 class="link-block-header">Resources</h3>
  <p>Learn about good data practices</p>
  </div>
</a>
<a class="link-div" href="/search?search_api_fulltext=">
  <div class="link-block" id="block-3">
  <img src="/modules/custom/ldbase_content/images/binoculars-fill.svg" alt="binoculars icon">
  <h3 class="link-block-header">Search</h3>
  <p>Find projects and data</p>
  </div>
</a>
<a class="link-div" href="/add-project">
  <div class="link-block" id="block-4">
  <img src="/modules/custom/ldbase_content/images/layout-text-window-reverse.svg" alt="form page icon">
  <h3 class="link-block-header">Add Data</h3>
  <p>Add your project to LDbase</p>
  </div>
</a><a class="link-div" href="/resources/first-time-storing-data">
  <div class="link-block" id="block-5">
  <img src="/modules/custom/ldbase_content/images/life-preserver.svg" alt="life preserver icon">
  <h3 class="link-block-header">New to LDbase?</h3>
  <p>Find help and support here</p>
  </div>
</a>
</div>
EOM;

    return [
      '#markup' => $content,
      '#allowed_tags' => ['div','a','p','h3','img'],
    ];
  }
}
