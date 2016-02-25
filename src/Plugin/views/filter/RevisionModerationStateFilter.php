<?php
/**
 * @file
 * Contains Drupal\gravypower_contrib\Plugin\views\field\RevisionModerationStateFilter.
 */

namespace Drupal\gravypower_contrib\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\Plugin\views\join\Subquery;
use Drupal\views\ViewExecutable;
use Drupal\views\Views;
use Drupal\workbench_moderation\Entity\ModerationState;
use Drupal\views\Plugin\views\query\Sql;

/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("revision_moderation_state_filter")
 */
class RevisionModerationStateFilter extends InOperator  {

    /**
     * {@inheritdoc}
     */
    public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
        parent::init($view, $display, $options);
        $this->valueTitle = t('Allowed node titles');
        $this->definition['options callback'] = array($this, 'generateOptions');
    }

    /**
     * Override the query so that no filtering takes place if the user doesn't
     * select any options.
     */
    public function query() {
        /** @var Sql $query */
        $query = $this->query;

        $configuration = array(
            'table' => 'node_field_revision',
            'field' => 'vid',
            'left_table' => 'node_field_data',
            'left_field' => 'vid',
            'operator' => '=',
            'type'=>'INNER',
            'left_query' => 'select max(vid) from node_field_revision where nid = nfr.nid',
            'extra' => 'node_field_data.nid = nfr.nid',
        );

        /** @var Subquery $join */
        $join = Views::pluginManager('join')->createInstance('subquery', $configuration);

        $query->addRelationship("nfr", $join ,'node_field_revision' );
        $query->addWhere(0, 'nfr.moderation_state',  $this->value, 'IN');
    }
    /**
     * Skip validation if no options have been chosen so we can use it as a
     * non-filter.
     */
    public function validate() {
        if (!empty($this->value)) {
            parent::validate();
        }
    }

    /**
     * Helper function that generates the options.
     * @return array
     */
    public function generateOptions() {
        $states = \Drupal::entityTypeManager()->getStorage('moderation_state')->loadMultiple();
        $options = [];
        /** @var ModerationState $state */
        foreach ($states as $key => $state) {
            $options[$key] = $state->label();
        }
        return $options;
    }
}
