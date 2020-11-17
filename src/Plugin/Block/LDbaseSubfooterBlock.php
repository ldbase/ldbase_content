<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides an LDbase Subfooter block.
 *
 * @Block(
 *   id="ldbase_subfooter_block",
 *   admin_label = @Translation("LDbase Subfooter Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseSubfooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<EOM
<div id="ldbase-footer-block-wrapper" id="ldbase-footer-block">
  <p>This work is licensed under a <a href="https://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>.<br />
  Contact us at <a href="mailto:LDbase@fcrr.org">LDbase@fcrr.org</a>.</p>
</div>
EOM;

    return [
      '#markup' => Markup::create($content),
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
