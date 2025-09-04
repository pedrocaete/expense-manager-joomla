<?php

/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

class ExpenseManagerTableTechnicalvisit extends JTable
{

    public function __construct($db)
    {
        parent::__construct('#__expensemanager_technical_visits', 'id', $db);
        $this->_trackAssets = false;
    }

    public function check()
    {
        if (empty($this->client_id) || (int) $this->client_id <= 0) {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_TECHNICALVISIT_CLIENT_ID_REQUIRED'));
            return false;
        }

        if (empty($this->analysis_start_date) || $this->analysis_start_date == $this->_db->getNullDate()) {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ANALYSIS_START_DATE_LABEL') . ' ' . JText::_('JLIB_FORM_VALIDATE_FIELD_INVALID'));
            return false;
        }

        if (empty($this->summary)) {
            $this->setError(JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_SUMMARY_LABEL') . ' ' . JText::_('JLIB_FORM_VALIDATE_FIELD_INVALID'));
            return false;
        }

        return true;
    }

    public function store($updateNulls = true)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        if (empty($this->id)) {
            $this->created    = $date->toSql();
            $this->created_by = $user->get('id');
        }

        $this->modified    = $date->toSql();
        $this->modified_by = $user->get('id');

        if (!isset($this->published)) {
            $this->published = 1;
        }

        return parent::store($updateNulls);
    }

    public function delete($pk = null)
    {
        $k  = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;

        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__expensemanager_technical_visit_consultants'))
            ->where($db->quoteName('technical_visit_id') . ' = ' . (int) $pk);

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }

        if (!parent::delete($pk)) {
            return false;
        }

        return true;
    }
}
