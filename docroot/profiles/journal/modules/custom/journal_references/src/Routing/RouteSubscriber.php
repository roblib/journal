<?php

namespace Drupal\journal_references\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection)
  {
    // Change path '/user/login' to '/login'.
    foreach (['bibcite_import.import', 'bibcite_import.populate'] as $route) {
      if ($route = $collection->get($route)) {
        $route->setRequirement('_permission', 'create bibcite_reference');
      }
    }
  }
}