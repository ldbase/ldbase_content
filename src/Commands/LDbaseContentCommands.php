<?php

namespace Drupal\ldbase_content\Commands;

use Drupal\Core\Extension\ExtensionPathResolver;
use Drupal\taxonomy\Entity\Term;
use Drush\Commands\DrushCommands;

/**
 * A Drush command file that imports taxonomy terms from text files in the ldbase_content module.
 */

class LDbaseContentCommands extends DrushCommands {

  /**
   * The Extension Path Resolver service.
   *
   * @var \Drupal\Core\Extension\ExtensionPathResolver
   */
  private $extensionPathResolver;

  /**
   * Constructs a new LDbaseContentCommands object.
   *
   * @param \Drupal\Core\Extension\ExtensionPathResolver $extensionPathResolver
   *   Extension Path Resolver service.
   */
  public function __construct(ExtensionPathResolver $extensionPathResolver)  {
    $this->extensionPathResolver = $extensionPathResolver;
  }

  /**
   * Import taxonomy terms from text files in the ldbase_content module.
   *
   * @command ldbase:import-taxonomy-terms
   */
  public function importTaxonomyTerms() {

    $this->logger()->notice("Beginning taxonomy term import...");
    $ldbase_content_path = DRUPAL_ROOT . "/" . $this->extensionPathResolver->getPath('module', 'ldbase_content');
    $ldbase_content_taxonomies_path = $ldbase_content_path . "/taxonomies/";
    $ldbase_taxonomy_terms_lists = scandir($ldbase_content_taxonomies_path);
    $dot_dir_filter = ['.', '..'];
    $taxonomies_filtered = array_diff($ldbase_taxonomy_terms_lists, $dot_dir_filter);

    foreach ($taxonomies_filtered as $file_name) {
      $this->logger()->notice("Importing terms from {$file_name}...");

      $taxonomy_name = str_replace('.txt', '', $file_name);
      $file_path = $ldbase_content_taxonomies_path . $file_name;
      $file = fopen($file_path, 'r');
      while(!feof($file)) {
        $line = fgets($file);
        $line = trim($line);
        if (!empty($line)) {
          $name = trim(explode('|', $line)[0]);
          $new_term = array(
            'parent' => array(),
            'vid' => $taxonomy_name,
            'name' => $name
          );
          if (array_key_exists('1',explode('|',$line))) {
            $added_field_values = trim(explode('|', $line)[1]);
            if (!empty($added_field_values) && $taxonomy_name == 'licenses') {
              $added_field_values = explode(',', $added_field_values);
              $field_valid_for = [];
              foreach ($added_field_values as $value) {
                array_push($field_valid_for, ['target_id' => $value]);
              }
              $new_term['field_valid_for'] = $field_valid_for;
            }
          }
          $term = Term::create($new_term);
          $term->save();
        }
      }
      fclose($file);
    }
    $this->logger()->success("Taxonomy terms imported.");
  }
}


