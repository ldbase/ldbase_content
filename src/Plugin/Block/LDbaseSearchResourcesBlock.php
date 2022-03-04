<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides an "LDbase Search Resources Block" block.
 *
 * @Block(
 *   id="ldbase_search_resources_block",
 *   admin_label = @Translation("LDbase Search Resources Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseSearchResourcesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<markup
<form class="views-exposed-form" action="/resources/search" method="get" id="search-ldbase-resources" accept-charset="UTF-8">
  <div class="form--inline clearfix">
  <div class="js-form-item form-item js-form-type-textfield form-type-textfield js-form-item-search-api-fulltext form-item-search-api-fulltext">
      <label for="edit-search-api-fulltext">Search LDbase Resources</label>
        <input data-drupal-selector="edit-search-api-fulltext" type="text" id="edit-search-api-fulltext" name="search_api_fulltext" size="30" maxlength="128" class="form-text" placeholder="Search resources ...">

            <div id="edit-search-api-fulltext--description" class="description">
      Find helpful information about LDbase and Open Science
    </div>
  </div>
<div data-drupal-selector="edit-actions" class="form-actions js-form-wrapper form-wrapper" id="edit-actions"><input data-drupal-selector="edit-submit-search-ldbase-resources" type="submit" id="edit-submit-search-ldbase-resources" value="Search Resources" class="button js-form-submit form-submit">
</div>

</div>

</form>

markup;
    return [
      '#markup' => Markup::create($content),
    ];
  }

}
