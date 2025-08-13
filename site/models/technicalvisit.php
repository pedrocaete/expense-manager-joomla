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

jimport('joomla.application.component.modeladmin');

class ExpenseManagerModelTechnicalvisit extends JModelAdmin
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
        }

        return $data;
    }

    public function save($data)
    {
        $db = $this->getDbo();
        
        $consultantIds = isset($data['consultant_id']) ? (array) $data['consultant_id'] : array();
        
        if (parent::save($data))
        {
            $visitId = (int) $this->getState($this->getName() . '.id');

            $query = $db->getQuery(true)
                ->delete($db->quoteName('#__expensemanager_technical_visit_consultants'))
                ->where($db->quoteName('technical_visit_id') . ' = ' . $visitId);
            $db->setQuery($query)->execute();

            if (!empty($consultantIds))
            {
                $query->clear()
                    ->insert($db->quoteName('#__expensemanager_technical_visit_consultants'))
                    ->columns(array(
                        $db->quoteName('technical_visit_id'),
                        $db->quoteName('consultant_id')
                    ));

                foreach ($consultantIds as $consultantId)
                {
                    $query->values($visitId . ', ' . (int) $consultantId);
                }

                $db->setQuery($query)->execute();
            }

            return true;
        }

        return false;
    }
}