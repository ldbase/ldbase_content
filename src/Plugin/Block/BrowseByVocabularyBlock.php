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
    $applies_to = ['funding_agencies', 'code_or_data_format', 'participants'];
    foreach ($vocabularies as $machine_name => $vocabulary) {
      if ($machine_name != 'tags') {
        switch ($machine_name) {
          case 'funding_agencies':
            $view_route = 'view.vocabulary_lists.funding_agencies';
            break;
          case 'participants':
            $view_route = 'view.vocabulary_lists.participants';
            break;
          case 'code_or_data_format':
            $view_route = 'view.vocabulary_lists.code_or_data_format';
            break;
          default:
            $view_route = 'view.vocabulary_lists.page_3';
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
