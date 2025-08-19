<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerModelTechnicalvisit extends JModelForm
{
    protected $text_prefix = 'COM_EXPENSEMANAGER_TECHNICALVISIT';

    public function getTable($type = 'Technicalvisit', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            'com_expensemanager.technicalvisit',
            'technicalvisit',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.technicalvisit.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
            $user = JFactory::getUser();
            $data['consultant_id'] = [$user->id];
        }
        return $data;
    }

    public function save($data)
    {
        if (!empty($data['visit_date']))
        {
            $date = new JDate($data['visit_date'], JFactory::getUser()->getTimezone());
            $data['visit_date'] = $date->toSql(true);
        }

        $table = $this->getTable();
        
        if (!$table->bind($data) || !$table->store())
        {
            $this->setError($table->getError());
            return false;
        }

        $db = $this->getDbo();
        $visitId = (int) $table->id;
        $consultantIds = isset($data['consultant_id']) ? (array) $data['consultant_id'] : array();
        
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__expensemanager_technical_visit_consultants'))
            ->where($db->quoteName('technical_visit_id') . ' = ' . $visitId);
        $db->setQuery($query)->execute();

        if (!empty($consultantIds))
        {
            $query->clear()
                ->insert($db->quoteName('#__expensemanager_technical_visit_consultants'))
                ->columns(array($db->quoteName('technical_visit_id'), $db->quoteName('consultant_id')));

            foreach ($consultantIds as $consultantId)
            {
                $query->values($visitId . ', ' . (int) $consultantId);
            }

            $db->setQuery($query)->execute();
        }

        return true;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');

        $table = $this->getTable();

        if ($pk > 0)
        {
            if (!$table->load($pk))
            {
                $this->setError($table->getError());
                return false;
            }
        }

        $item = $table->getProperties(1);

        if (!empty($item['id']))
        {
            $db    = $this->getDbo();
            $query = $db->getQuery(true)
                ->select($db->quoteName('consultant_id'))
                ->from($db->quoteName('#__expensemanager_technical_visit_consultants'))
                ->where($db->quoteName('technical_visit_id') . ' = ' . (int) $item['id']);

            $db->setQuery($query);
            
            $item['consultant_id'] = $db->loadColumn();
        }

        return $item;
    }
}