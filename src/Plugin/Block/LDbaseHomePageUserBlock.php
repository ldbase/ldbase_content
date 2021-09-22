<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user_email_verification\UserEmailVerification;

/**
 * Provides home page user block
 *
 * @Block (
 *   id = "home_page_user_block",
 *   admin_label = @Translation("Home Page User Logged In Block"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class LDbaseHomePageUserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * An entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The User Email Verification service.
   *
   * @var \Drupal\user_email_verification\UserEmailVerification
   */
  protected $userEmailVerification;

  /**
   * Constructs a Home Page User Block
   *
   * @param array $configuration
   *   Block configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   An entity type manager.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The Current User
   * @param \Drupal\user_email_verification\UserEmailVerification $userEmailVerification
   *   User Email Verification Service
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_manager, AccountInterface $currentUser, UserEmailVerification $userEmailVerification) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityManager = $entity_manager;
    $this->currentUser = $currentUser;
    $this->userEmailVerification = $userEmailVerification;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('current_user'),
      $container->get('user_email_verification.service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $dashboard_route = 'entity.user.canonical';
    $messages_route = 'view.my_messages.page_1';
    $contributions_route = 'entity.node.canonical';
    $profile_edit_route = 'ldbase_handlers.edit_person';
    $taxonomy_review_route = 'ldbase_handlers.review_taxonomy_terms';
    $email_verification_route = 'user_email_verification.request';
    $uid = $this->currentUser->id();
    $ldbase_person_id = \Drupal::entityQuery('node')
      ->condition('type', 'person')
      ->condition('field_drupal_account_id', $uid)
      ->execute();

    if (!empty($ldbase_person_id)) {
      $ldbase_person = $this->entityManager->getStorage('node')->load(array_values($ldbase_person_id)[0]);

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
        $name = $this->entityManager->getStorage('node')->load($value['target_id'])->getTitle();
        array_push($person_related_organizations, $name);
      }

      $dashboard_url = Url::fromRoute($dashboard_route, ['user' => $uid]);
      $dashboard_link = Link::fromTextAndUrl(t('Go to Dashboard'), $dashboard_url)->toRenderable();
      $messages_url = Url::fromRoute($messages_route, ['user' => $uid]);
      $messages_link = Link::fromTextAndUrl(t('View Messages'), $messages_url)->toRenderable();
      $contributions_url = Url::fromRoute($contributions_route, ['node' => $ldbase_person->id()]);
      $contributions_link = Link::fromTextAndUrl(t('View Contributions'), $contributions_url)->toRenderable();
      $profile_edit_url = Url::fromRoute($profile_edit_route, ['node' => $ldbase_person->uuid()]);
      $profile_edit_link = Link::fromTextAndUrl(t('Edit your Profle'), $profile_edit_url)->toRenderable();
      $taxonomy_review_url = Url::fromRoute($taxonomy_review_route);
      if ($taxonomy_review_url->access($this->currentUser)) {
        $taxonomy_review_link = Link::fromTextAndUrl(t('Review Taxonomy Terms'), $taxonomy_review_url)->toRenderable();
      }
      else {
        $taxonomy_review_link = NULL;
      }
      $email_needs_verification = $this->userEmailVerification->isVerificationNeeded($uid);
      $verification_url = Url::fromRoute($email_verification_route);
      $verification_link = Link::fromTextAndUrl(t('Verify Email'), $verification_url)->toRenderable();


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
        '#email_needs_verification' => $email_needs_verification,
        '#verification_link' => $verification_link,
        '#cache' => [
          'tags' => $cache_tags,
          'contexts' => ['user','user_email_verification_needed'],
        ],
      ];

      return $render;

    }
    else {
      return [];
    }
  }
}
