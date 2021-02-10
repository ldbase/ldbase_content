<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a link to Contributions Page.
 *
 * @Block(
 *   id="contributions_link",
 *   admin_label = @Translation("Link to Contributions (Person) Page"),
 *   category = @Translation("LDbase Block")
 * )
 */
class ContributionsLink extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user_id = \Drupal::currentUser()->id();
    $query_result = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['field_drupal_account_id' => $user_id]);

    if ($query_result) {
      $person = array_values($query_result)[0];
      return [
        '#markup' => $this->t("<div><a class=\"button\" href=\"/persons/{$person->uuid()}\">View Contributions</a></div>"),
      ];
    }
    else {
      return [];
    }
  }

}
