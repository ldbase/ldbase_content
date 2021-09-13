<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * @Block(
 *   id = "new_search_link",
 *   admin_label = @Translation("LDbase New Search Link"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class NewSearchLink extends BlockBase {
   /**
   * {@inheritdoc}
   */
  public function build() {
    $route = 'view.search.page_1';
    $text = 'Start New Search';
    $class[] = 'ldbase-new-search-link';

    $url = Url::fromRoute($route);
    $link = Link::fromTextAndUrl(t($text), $url)->toRenderable();
    $link['#attributes'] = ['class' => $class];
    $markup .= render($link) . ' ';

    $block = [
      '#type' => 'markup',
      '#markup' => $markup,
    ];

    return $block;
  }
 }
