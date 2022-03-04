<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides an "LDbase Banner Text Block" block.
 *
 * @Block(
 *   id="ldbase_banner_text_block",
 *   admin_label = @Translation("LDbase Banner Text Overlay Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseBannerTextBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<markup
<div id="ldbase-hero-overlay-text">

<h2><span class="spell-it-out">L</span>earning &amp; <span class="spell-it-out">D</span>evelopment Data<span class="spell-it-out">base</span></h2>
<p>Developmental and educational sciences research data<br/>
No data formatting requirements: uploading is a breeze!<br/>
All data organized by Project/Research Study<br/>
Funded by NIH; FREE for everyone and always will be!</p>
</div>
markup;
    return [
      '#markup' => Markup::create($content),
    ];
  }

}
