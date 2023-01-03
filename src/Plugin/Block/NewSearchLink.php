<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Render\RendererInterface;

/**
 * @Block(
 *   id = "new_search_link",
 *   admin_label = @Translation("LDbase New Search Link"),
 *   category = @Translation("LDbase Block")
 * )
 */

 class NewSearchLink extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The Renderer service
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a NewSearchLink object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RendererInterface $renderer) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container
      ->get('renderer'));
  }

   /**
   * {@inheritdoc}
   */
  public function build() {
    $url_input = '/search?search_api_fulltext=';
    $text = 'Start New Search';
    $class[] = 'ldbase-new-search-link';

    $url = Url::fromUserInput($url_input);
    $link = Link::fromTextAndUrl(t($text), $url)->toRenderable();
    $link['#attributes'] = ['class' => $class];
    $markup = $this->renderer->render($link) . ' ';

    $block = [
      '#type' => 'markup',
      '#markup' => $markup,
    ];

    return $block;
  }
 }
