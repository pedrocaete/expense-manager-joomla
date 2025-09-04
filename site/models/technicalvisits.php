<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

class ExpensemanagerModelTechnicalvisits extends JModelList
{

    protected function getListQuery()
    {
        $db = $this->getDbo();

        $query = $db->getQuery(true);

        $user = JFactory::getUser();
        $userId = (int) $user->get('id');

        $query->select(
            $this->getState(
                'list.select',
                array(
                    $db->quoteName('tv.id'),
                    $db->quoteName('tv.analysis_start_date'),
                    $db->quoteName('c.name', 'client_name'),
                    'GROUP_CONCAT(u_consultant.name SEPARATOR ", ") AS consultants'
                )
            )
        );

        $query->from($db->quoteName('#__expensemanager_technical_visits', 'tv'));
        $query->join('LEFT', $db->quoteName('#__expensemanager_clients', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('tv.client_id') . ')');
        $query->join('LEFT', $db->quoteName('#__expensemanager_technical_visit_consultants', 'tvc') . ' ON (' . $db->quoteName('tvc.technical_visit_id') . ' = ' . $db->quoteName('tv.id') . ')');
        $query->join('LEFT', $db->quoteName('#__users', 'u_consultant') . ' ON (' . $db->quoteName('u_consultant.id') . ' = ' . $db->quoteName('tvc.consultant_id') . ')');

        $query->where($db->quoteName('tv.created_by') . ' = ' . $userId);

        $query->group($db->quoteName('tv.id'));

        $query->order($db->quoteName('tv.analysis_start_date') . ' DESC');

        return $query;
    }

    protected function populateState($ordering = null, $direction = null)
    {
        parent::populateState('analysis_start_date', 'DESC');

        $app = JFactory::getApplication();

        $limit = 10;
        $this->setState('list.limit', $limit);

        $limitstart = $app->input->getInt('start', 0);
        $this->setState('list.start', $limitstart);
    }
}
