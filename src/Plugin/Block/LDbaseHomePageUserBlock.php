<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides home page user block
 *
 * @Block (
 *   id = "home_page_user_block",
 *   admin_label = @Translation("Home Page User Logged In Block"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class LDbaseHomePageUserBlock extends BlockBase {

  public function build() {
    $entity_type_manager = \Drupal::entityTypeManager();
    $current_user = \Drupal::currentUser();
    $dashboard_route = 'entity.user.canonical';
    $messages_route = 'view.my_messages.page_1';
    $contributions_route = 'entity.node.canonical';
    $profile_edit_route = 'ldbase_handlers.edit_person';
    $taxonomy_review_route = 'ldbase_handlers.review_taxonomy_terms';

    $ldbase_person_id = \Drupal::entityQuery('node')
      ->condition('type', 'person')
      ->condition('field_drupal_account_id', $current_user->id())
      ->execute();

    if (!empty($ldbase_person_id)) {
      $ldbase_person = $entity_type_manager->getStorage('node')->load(key($ldbase_person_id));

      $person_first_name = $ldbase_person->field_first_name->value;
      $person_middle_name = $ldbase_person->field_middle_name->value;
      $person_last_name = $ldbase_person->field_last_name->value;
      $person_name = $person_first_name . ' ' . $person_middle_name . ' ' . $person_last_name;

      $person_email = $ldbase_person->field_email->value;
      $person_orcid = $ldbase_person->field_orcid->value;
      $person_professional_titles = $ldbase_person->field_professional_titles->getValue();

      $institutions = $ldbase_person->field_related_organizations->getValue();
      $person_related_organizations = [];
      foreach ($institutions as $value) {
        $name = $entity_type_manager->getStorage('node')->load($value['target_id'])->getTitle();
        array_push($person_related_organizations, $name);
      }

      $dashboard_url = Url::fromRoute($dashboard_route, ['user' => $current_user->id()]);
      $dashboard_link = Link::fromTextAndUrl(t('Go to Dashboard'), $dashboard_url)->toRenderable();
      $messages_url = Url::fromRoute($messages_route, ['user' => $current_user->id()]);
      $messages_link = Link::fromTextAndUrl(t('View Messages'), $messages_url)->toRenderable();
      $contributions_url = Url::fromRoute($contributions_route, ['node' => $ldbase_person->id()]);
      $contributions_link = Link::fromTextAndUrl(t('View Contributions'), $contributions_url)->toRenderable();
      $profile_edit_url = Url::fromRoute($profile_edit_route, ['node' => $ldbase_person->uuid()]);
      $profile_edit_link = Link::fromTextAndUrl(t('Edit your Profle'), $profile_edit_url)->toRenderable();
      $taxonomy_review_url = Url::fromRoute($taxonomy_review_route);
      if ($taxonomy_review_url->access($current_user)) {
        $taxonomy_review_link = Link::fromTextAndUrl(t('Review Taxonomy Terms'), $taxonomy_review_url)->toRenderable();
      }
      else {
        $taxonomy_review_link = NULL;
      }


      $cache_tags = [
          "node:{$ldbase_person->id()}",
      ];

      $render = [
        '#theme' => 'ldbase_content_home_page_user_block',
        '#person_name' => $person_name,
        '#person_orcid' => $person_orcid,
        '#person_email' => $person_email,
        '#person_professional_titles' => $person_professional_titles,
        '#person_related_organizations' => implode($person_related_organizations, ', '),
        '#dashboard_link' => $dashboard_link,
        '#messages_link' => $messages_link,
        '#contributions_link' => $contributions_link,
        '#profile_edit_link' => $profile_edit_link,
        '#taxonomy_review_link' => $taxonomy_review_link,
        '#cache' => [
          'tags' => $cache_tags,
          'context' => ['user'],
        ],
      ];

      return $render;

    }
    else {
      return [];
    }
  }
}
