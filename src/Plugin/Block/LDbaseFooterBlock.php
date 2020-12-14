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
  <p>Welcome to LDbase, a NIH-funded collaboration between researchers and librarians to build a first-of-its-kind behavioral data repository containing decades of knowledge from educational and developmental sciences on individuals across the full range of abilities. LDbase is an open science resource for the educational and developmental science scientific communities, providing a secure place to store and access data and access materials about aspects of data management and analyses. The aim of LDbase is to be a powerful resource that opens up new areas of research and accelerates discoveries, inspiring innovative research that helps us understand how individuals learn, develop, are different from each other, learn new languages, respond to interventions, and interact with their communities.</p>
  <p>You may cite LDbase: Hart, S.A., Schatschneider, S., Reynolds, T.R., Calvo, F.E., Brown, B.J., Arsenault, B., Hall, M.R.K., van Dijk, W., Edwards, A.A., Shero, J.A., Smart, R. & Phillips, J.S. (2020). <em>LDbase</em>. <a href="http://doi.org/10.33009/ldbase">http://doi.org/10.33009/ldbase</a>.</p>
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
