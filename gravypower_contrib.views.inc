<?php

function gravypower_contrib_views_data_alter(array &$data)
{
    $data['node']['latest_revision_moderation_state'] = array(
        'title' => t('Latest revision moderation state'),
        'field' => array(
            'title' => t('Latest revision moderation state'),
            'help' => t('Gets the moderation state of the latest revision'),
            'id' => 'latest_revision_moderation_state',
        ),
    );

    $data['node']['revision_moderation_state_filter'] = array(
        'title' => t('Revision Moderation State'),
        'filter' => array(
            'title' => t('Revision Moderation State'),
            'help' => t('Specify a list of Revision Moderation States.'),
            'field' => 'revision_moderation_state',
            'id' => 'revision_moderation_state_filter'
        ),
    );
}