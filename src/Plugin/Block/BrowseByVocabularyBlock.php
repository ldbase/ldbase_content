<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides "Brose by Vocabulary" block
 *
 * @Block (
 *   id = "browse_by_vocabulary_block",
 *   admin_label = @Translation("Browse by Vocabulary Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class BrowseByVocabularyBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $vocabularies = Vocabulary::loadMultiple();
    $vocabularies_count = count($vocabularies);
    $vocabulary_links = [];

    foreach ($vocabularies as $machine_name => $vocabulary) {
      if ($machine_name != 'tags') {
        if ($machine_name == 'funding_agencies') {
          $view_route = 'view.vocabulary_lists.page_2';
        }
        else {
          $view_route = 'view.vocabulary_lists.page_1';
        }
        $url = Url::fromRoute($view_route, ['vocabulary' => $vocabulary->id()]);
        $link_text = $vocabulary->get('name');
        $link = Link::fromTextAndUrl(t($link_text), $url)->toRenderable();
        $vocabulary_links[] = ['link' => $link, 'title' => $link_text];
      }
    }

    usort($vocabulary_links, function($a, $b){
      return $a['title'] <=> $b['title'];
    });

    $render = [
      '#theme' => 'ldbase_content_browse_vocabularies',
      '#count' => $vocabularies_count,
      '#vocabulary_links' => $vocabulary_links,
    ];

    return $render;
  }

}
