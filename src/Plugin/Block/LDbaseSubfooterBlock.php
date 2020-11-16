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
    <div id="ldbase-subfooter-block-wrapper" id="ldbase-subfooter-block">
      <p>This work is licensed under a <a href="https://creativecommons.org/licenses/by/4.0/">Creative Commons Attribution 4.0 International License</a>. You may cite LDbase: <br /><br /> Hart, S.A., Schatschneider, T.R. Reynolds, F.E. Calvo, B. J. Brown, B. Arsenault, M.R.K. Hall, W. van Dijk, A.A. Edwards, J.A. Shero, R. Smart & J.S. Phillips (2020). <em>LDbase</em>. <a href="http://doi.org/10.33009/ldbase">http://doi.org/10.33009/ldbase</a>.</p>
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
