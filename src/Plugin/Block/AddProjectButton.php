<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Add Project Button" block.
 *
 * @Block(
 *   id="add_project_button",
 *   admin_label = @Translation("Add Project Button"),
 *   category = @Translation("LDbase Block")
 * )
 */
class AddProjectButton extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form_url = '/add-project';
    return [
      '#markup' => $this->t("<div><a class=\"button\" href=\"{$form_url}\">Add Project</a></div>"),
    ];
  }
}
