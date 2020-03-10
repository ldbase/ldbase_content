<?php

namespace Drupal\ldbase_content\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\ContainerAwareCommand;
use Drupal\taxonomy\Entity\Term;

/**
 * Class LDbaseTermImporterCommand.
 *
 * Drupal\Console\Annotations\DrupalCommand (
 *     extension="ldbase_content",
 *     extensionType="module"
 * )
 */
class LDbaseTermImporterCommand extends ContainerAwareCommand {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('ldbase:importTerms')
      ->setDescription($this->trans('Import taxonomy terms from text files in the ldbase_content module.'));
  }

  /**
   * {@inheritdoc}
   */
  protected function initialize(InputInterface $input, OutputInterface $output) {
    parent::initialize($input, $output);

  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
  }

  /**
   * {@inheritdoc}
   */
  
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->getIo()->info("Beginning taxonomy term import...");
    $ldbase_content_path = DRUPAL_ROOT . "/" . drupal_get_path('module', 'ldbase_content');
    $ldbase_content_taxonomies_path = $ldbase_content_path . "/taxonomies/"; 
    $ldbase_taxonomy_terms_lists = scandir($ldbase_content_taxonomies_path);
    $dot_dir_filter = ['.', '..'];
    $taxonomies_filtered = array_diff($ldbase_taxonomy_terms_lists, $dot_dir_filter);
    foreach ($taxonomies_filtered as $file_name) {
      $this->getIo()->info("Importing terms from {$file_name}...");
      $ldbase_content_path = DRUPAL_ROOT . "/" . drupal_get_path('module', 'ldbase_content');
      $taxonomy_name = str_replace('.txt', '', $file_name);
      $file_path = $ldbase_content_taxonomies_path . $file_name;
      $file = fopen($file_path, 'r');
      while(!feof($file)) {
        $line = fgets($file);
        $line = trim($line);
	if (!empty($line)) {
          $term = Term::create(array(
            'parent' => array(),
            'vid' => $taxonomy_name,
	    'name' => $line            
          ))->save();
        }
      }
      fclose($file);
    }
    $this->getIo()->success("Taxonomy terms imported.");
  }

}
