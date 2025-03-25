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
  <p id="subfooter-disclaimer">This repository is a collaboration between the <a href="https://psy.fsu.edu/">FSU Department of Psychology</a>, the <a href="https://fcrr.org">Florida Center for Reading Research</a>,
  and the <a href="https://www.lib.fsu.edu/">FSU Libraries</a>. The content is solely the responsibility of the authors and does not necessarily represent the official views of the National Institutes of Health.<br /><br />
  On March 25, 2025, the NIH requested that we post this text: "This repository is under review for potential modification in compliance with Administration directives."<br /><br />
  <strong>Questions or Comments?</strong> <a href="/contact-us">Contact us or report a problem</a>.</p>
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
