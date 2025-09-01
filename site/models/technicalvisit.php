<?php
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

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.technicalvisit.data', array());

        if (empty($data))
        {
            $item = $this->getItem();

            if (empty($item->id)) {
                $user = JFactory::getUser();
                $item->consultant_id = array($user->id);
            }
            
            $data = (array) $item;
        }

        return $data;
    }

    public function save($data)
    {
        $dateFields = [
            'analysis_start_date', 'analysis_end_date', 'contract_start_date', 
            'contract_end_date', 'loa_date', 'ldo_date', 'ppa_date'
        ];

        foreach ($dateFields as $field) {
            if (!empty($data[$field])) {
                try {
                    $date = new JDate($data[$field], JFactory::getUser()->getTimezone());
                    $data[$field] = $date->toSql(true);
                } catch (Exception $e) {
                    $data[$field] = null;
                    JFactory::getApplication()->enqueueMessage('Formato de data inválido para ' . $field, 'warning');
                }
            } else {
                $data[$field] = null;
            }
        }

        $table = $this->getTable();

        if (!$table->bind($data) || !$table->store()) {
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

        if (!empty($consultantIds)) {
            $query->clear()
                ->insert($db->quoteName('#__expensemanager_technical_visit_consultants'))
                ->columns(array($db->quoteName('technical_visit_id'), $db->quoteName('consultant_id')));

            foreach ($consultantIds as $consultantId) {
                $query->values($visitId . ', ' . (int) $consultantId);
            }

            $db->setQuery($query)->execute();
        }

        return true;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) JFactory::getApplication()->input->getInt('id');

        if ($pk > 0)
        {
            try
            {
                $db    = $this->getDbo();
                $query = $db->getQuery(true);

                $query->select(
                    array(
                        'tv.*',
                        'c.name AS client_name',
                        'GROUP_CONCAT(u.name SEPARATOR ", ") AS consultants'
                    )
                )
                ->from($db->quoteName('#__expensemanager_technical_visits', 'tv'))
                ->join('LEFT', $db->quoteName('#__expensemanager_clients', 'c') . ' ON c.id = tv.client_id')
                ->join('LEFT', $db->quoteName('#__expensemanager_technical_visit_consultants', 'tvc') . ' ON tvc.technical_visit_id = tv.id')
                ->join('LEFT', $db->quoteName('#__users', 'u') . ' ON u.id = tvc.consultant_id')
                ->where('tv.id = ' . (int) $pk)
                ->group('tv.id');

                $db->setQuery($query);
                $item = $db->loadObject();

                if ($item) {
                    $query->clear()
                        ->select($db->quoteName('consultant_id'))
                        ->from($db->quoteName('#__expensemanager_technical_visit_consultants'))
                        ->where($db->quoteName('technical_visit_id') . ' = ' . (int) $pk);
                    $db->setQuery($query);
                    $item->consultant_id = $db->loadColumn();
                }

                return $item;
            }
            catch (Exception $e)
            {
                $this->setError($e->getMessage());
                return false;
            }
        }

        return new stdClass();
    }
}