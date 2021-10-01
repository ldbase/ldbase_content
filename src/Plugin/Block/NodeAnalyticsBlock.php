<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;
use Drupal\file\Entity\File;

/**
 * Provides a "Node Analytics" block.
 *
 * @Block(
 *   id="node_analytics_block",
 *   admin_label = @Translation("Node Analytics Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class NodeAnalyticsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $matomo_enabled = \Drupal::service('module_handler')->moduleExists('matomo');
    if (!$matomo_enabled) {
      $content = 'Matomo not enabled';
    }
    else if ($matomo_enabled) {
      $matomo_config = \Drupal::config('matomo.settings');
      $matomo_url = $matomo_config->get('url_http');
      $matomo_id = $matomo_config->get('site_id');
      $matomo_token = \Drupal::config('ldbase_admin.settings')->get('ldbase_matomo_user_token');
      if ($matomo_url == '' || $matomo_id == '') {
        $content = 'Matomo not configured';
      }
      if ($matomo_token == '') {
        $content = "Matomo user token not set";
      }
      else {
        $node = \Drupal::routeMatch()->getParameter('node');
        $path = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $node->id()])->toString();
        global $base_url;
        $current_page_url = $base_url . $path;
        $ctype = $node->getType();
        $current_date = date('Y-m-d', time());
        $date_range = "2000-01-01,{$current_date}";
        $matomo_url = str_replace(':9999', '', $matomo_url);
        $request_url = $matomo_url . "index.php?module=API&method=Actions.getPageUrl&pageUrl={$current_page_url}&idSite={$matomo_id}&period=range&date={$date_range}&format=json&token_auth={$matomo_token}";
        $response = json_decode(file_get_contents($request_url), TRUE);
        if (empty($response)) {
          $pageviews_row = <<<EOS
<div id='node_analytics_block_pageviews' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_pageviews_label' class='node_analytics_block node_analytics_block_label'><strong>Page Views:</strong>
<span id='node_analytics_block_pageviews_value' class='node_analytics_block node_analytics_block_value'>Pending</span>
</div><br>
EOS;
        }
        else {
          if ($response['result'] == 'error') {
            $pageviews_row = "Error: Can't authenticate to Matomo server";
          }
          else {
            $pageviews = (int) $response[0]['nb_hits'];
            $pageviews_row = <<<EOS
<div id='node_analytics_block_pageviews' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_pageviews_label' class='node_analytics_block node_analytics_block_label'><strong>Page Views:</strong>
<span id='node_analytics_block_pageviews_value' class='node_analytics_block node_analytics_block_value'>{$pageviews}</span>
</div><br>
EOS;
          }
        }

        $downloadable_ctypes = ['dataset', 'code', 'document'];
        if (in_array($ctype, $downloadable_ctypes)) {
          $download_file_urls = array();
          switch ($ctype) {
            case 'dataset':
              $files = [];
              foreach ($node->field_dataset_version as $delta => $file_metadata_paragraph) {
                $p = $file_metadata_paragraph->entity;
                $file_id = $p->field_file_upload->entity->id();
                $file = File::load($file_id);
                $file_uri = $file->getFileUri();
                $file_url = file_create_url($file_uri);
                $download_file_urls[] = $file_url;
              }
              break;
            case 'code':
              $code_file = $node->field_code_file->entity;
              $code_file_id = !empty($code_file) ? $code_file->id() : NULL;
              if (!is_null($code_file_id)) {
                $file = File::load($code_file_id);
                $file_uri = $file->getFileUri();
                $file_url = file_create_url($file_uri);
                $download_file_urls[] = $file_url;
              }
              break;
            case 'document':
              $document_file = $node->field_document_file->entity;
              $document_file_id = !empty($document_file) ? $document_file->id() : NULL;
              if (!is_null($document_file_id)) {
                $file = File::load($document_file_id);
                $file_uri = $file->getFileUri();
                $file_url = file_create_url($file_uri);
                $download_file_urls[] = $file_url;
              }
              break;
          }
        }
        else {
          $download_file_urls = [];
        }

        $total_downloads = 0;
        foreach ($download_file_urls as $file_url) {
          $request_url = $matomo_url . "index.php?module=API&method=Actions.getDownload&downloadUrl={$file_url}&idSite={$matomo_id}&period=range&date={$date_range}&format=json&token_auth={$matomo_token}";
          $response = json_decode(file_get_contents($request_url), TRUE);
          if (empty($response)) {
            $file_downloads = 0;
          }
          else {
            $file_downloads = (int) $response[0]['nb_hits'];
          }
          $total_downloads = $total_downloads + $file_downloads;
        }
        if ($total_downloads > 0) {
          $downloads_row = <<<EOS
<span id='node_analytics_block_downloads' class='node_analytics_block node_analytics_block_row'>
<span id='node_analytics_block_downloads_label' class='node_analytics_block node_analytics_block_label'><strong>Downloads:</strong>
<span id='node_analytics_block_downloads_value' class='node_analytics_block node_analytics_block_value'>{$total_downloads}</span>
</span><br>
EOS;
        }
        else {
          $downloads_row = '';
        }

        $content = "<div id='node_analytics_block_wrapper' class='node_analtyics_block'><br>";
        $content .= $pageviews_row;
        $content .= $downloads_row;
        $content .= "</div>";
      }
    }

    return [
      '#markup' => Markup::create($content),
    ];
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
