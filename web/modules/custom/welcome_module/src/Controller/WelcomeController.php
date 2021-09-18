<?php

namespace Drupal\welcome_module\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;

/**
 * Controller for custom module.
 */
class WelcomeController {

  /**
   * Return string to menu.
   */
  public function myMenu() {
    return [
      '#markup' => 'Welcome to my_menu.',
    ];
  }

  /**
   * Return string to sub menu.
   */
  public function subMenu() {
    return [
      '#markup' => 'Welcome to sub_menu.',
    ];
  }

  /**
   * Return string on main page.
   */
  public function welcome() {
    return [
      '#markup' => 'Welcome to my Website.',
    ];
  }

  /**
   * Return string on page 'Smile_test'.
   */
  public function smileTest() {
    return [
      '#markup' => 'It is my first route ever',
    ];
  }

  /**
   * Node rendered function with node id.
   */
  public function nodeRender($nid) {
    try {
      $node = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->load($nid);
      $element = \Drupal::entityTypeManager()
        ->getViewBuilder('node')
        ->view($node, 'teaser');
      $output = render($element);
      return [
        '#markup' => $output,
      ];
    }
    catch (InvalidPluginDefinitionException | PluginNotFoundException $e) {
      return $e->getMessage();
    }
  }

  /**
   * Function to control access to page 'node_render/{nid}'.
   */
  public function hasAccessOfSuperuser() {
    return \Drupal::currentUser()->hasPermission('superuser');
  }

}
