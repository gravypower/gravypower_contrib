<?php
/**
 * @file
 * Contains Drupal\gravypower_contrib\Plugin\views\field\LatestRevisionModerationState.
 */

namespace Drupal\gravypower_contrib\Plugin\views\field;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\workbench_moderation\Entity\ModerationState;
use Drupal\workbench_moderation\ModerationInformation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Field handler to find the Latest Revision Moderation State
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("latest_revision_moderation_state")
 */
class LatestRevisionModerationState extends FieldPluginBase implements ContainerFactoryPluginInterface {

    /**
     * The moderatio information service.
     *
     * @var \Drupal\workbench_moderation\ModerationInformation
     */
    protected $moderationInfo;

    /**
     * LatestRevisionModerationState constructor.
     * @param array $configuration
     * @param string $plugin_id
     * @param mixed $plugin_definition
     * @param ModerationInformation $moderation_information
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, ModerationInformation $moderation_information)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->moderationInfo = $moderation_information;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('workbench_moderation.moderation_information')
        );
    }

    public function query() {
    }

    /**
     * @{inheritdoc}
     * @param ResultRow $values
     * @return \Drupal\Component\Render\MarkupInterface|\Drupal\Core\StringTranslation\TranslatableMarkup|\Drupal\views\Render\ViewsRenderPipelineMarkup|string
     */
    public function render(ResultRow $values) {
        $entity_type_id = $values->_entity->getEntityTypeId();
        $entity_id = $values->_entity->id();

        /** @var ModerationState $latestRevision */
        $latestRevision = $this->moderationInfo->getLatestRevision($entity_type_id, $entity_id);

        return $this->t($latestRevision->moderation_state->entity->label());
    }
}