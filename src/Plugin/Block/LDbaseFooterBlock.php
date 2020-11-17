<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides an "LDbase Footer block.
 *
 * @Block(
 *   id="ldbase_footer_block",
 *   admin_label = @Translation("LDbase Footer Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<EOM
<div id="ldbase-footer-block-wrapper" id="ldbase-footer-block">
  <h5>About LDbase</h5>
  <p>This repository is a collaboration between the <a href="https://psy.fsu.edu/">FSU Department of Psychology</a> and the <a href="https://www.lib.fsu.edu/">FSU Libraries</a>.
  It is based on work supported by the Eunice Kennedy Shriver National Institute of Child Health and Human Development under R01HD095193. The content is solely the responsibility of the authors and does not necessarily represent the official views of the National Institutes of Health.</p>
  <p>You may cite LDbase: Hart, S.A., Schatschneider, T.R. Reynolds, F.E. Calvo, B. J. Brown, B. Arsenault, M.R.K. Hall, W. van Dijk, A.A. Edwards, J.A. Shero, R. Smart & J.S. Phillips (2020). <em>LDbase</em>. <a href="http://doi.org/10.33009/ldbase">http://doi.org/10.33009/ldbase</a>.</p>
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
