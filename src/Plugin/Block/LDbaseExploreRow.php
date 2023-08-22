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
<a class="link-div" href="/help">
  <div class="link-block" id="block-5">
  <img src="/modules/custom/ldbase_content/images/life-preserver.svg" alt="life preserver icon">
  <p class="link-block-header">New to LDbase?</p>
  <p>Find help and support here</p>
  </div>
</a>
<a class="link-div" href="/browse-data">
 <div class="link-block" id="block-1">
  <img src="/modules/custom/ldbase_content/images/bookshelf.svg" alt="bookshelf icon">
  <p class="link-block-header">Browse Data</p>
  <p>See what's in LDbase</p>
  </div>
</a>
<a class="link-div" href="/data-sharing-resources">
  <div class="link-block" id="block-2">
  <img src="/modules/custom/ldbase_content/images/signpost-2.svg" alt="signpost icon">
  <p class="link-block-header">Data Sharing Resources</p>
  <p>Learn about good data practices</p>
  </div>
</a>
<a class="link-div" href="/search">
  <div class="link-block" id="block-3">
  <img src="/modules/custom/ldbase_content/images/binoculars-fill.svg" alt="binoculars icon">
  <p class="link-block-header">Search</p>
  <p>Find projects and data</p>
  </div>
</a>
<a class="link-div" href="/add-project">
  <div class="link-block" id="block-4">
  <img src="/modules/custom/ldbase_content/images/layout-text-window-reverse.svg" alt="form page icon">
  <p class="link-block-header">Start a Project</p>
  <p>Add my data to LDbase</p>
  </div>
</a>
</div>
EOM;

    return [
      '#markup' => $content,
      '#allowed_tags' => ['div','a','p','img'],
    ];
  }
}
