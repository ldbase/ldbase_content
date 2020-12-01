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
<div id="ldbase-subfooter-block-wrapper">
  <p id="subfooter-disclaimer">This repository is a collaboration between the <a href="https://psy.fsu.edu/">FSU Department of Psychology</a> and the <a href="https://www.lib.fsu.edu/">FSU Libraries</a>.<br />
  The content is solely the responsibility of the authors and does not necessarily represent the official views of the National Institutes of Health.<br /><br />
  <strong>Questions or Comments?</strong> Contact us at <a href="mailto:LDbase@fcrr.org">LDbase@fcrr.org</a>.</p>
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