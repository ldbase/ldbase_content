<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides a second LDbase Subfooter block.
 *
 * @Block(
 *   id="ldbase_subfooter_two_block",
 *   admin_label = @Translation("LDbase Subfooter Two Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseSubfooterTwoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $content = <<<EOM
<div id="ldbase-subfooter-two-block-wrapper">
  <p id="subfooter-sponsor"><img src="/modules/custom/ldbase_content/images/nih-logo.png" alt="NIH logo">
  <span> <a href="https://reporter.nih.gov/search/WlJaDdpsl0uxVI9jK5SQ2g/project-details/10543102"> Grant #R01HD095193</a></span></p>
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
