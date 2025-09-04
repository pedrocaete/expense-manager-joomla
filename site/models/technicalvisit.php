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

        if (empty($data)) {
            $item = $this->getItem();

            if (empty($item->id)) {
                $user = JFactory::getUser();
                $item->consultant_id = array($user->id);

                $editorFieldsWithDefaults = [
                    'budget_expense_realization_notes',
                    'budget_revenue_collection_notes',
                    'budget_art167a_compliance_notes',
                    'duodecimo_art29a_calc_notes',
                    'duodecimo_transfer_calc_notes',
                    'indices_education_25_notes',
                    'indices_fundeb_application_notes',
                    'indices_art212a_chart_notes',
                    'indices_health_spending_notes',
                    'indices_personnel_expenses_notes',
                    'indices_financial_availability_notes'
                ];

                foreach ($editorFieldsWithDefaults as $fieldName) {
                    if (empty($item->$fieldName)) {
                        $item->$fieldName = $this->_getDefaultEditorContent($fieldName);
                    }
                }
            }

            $data = (array) $item;
        }

        return $data;
    }

    private function _getDefaultEditorContent($fieldName)
    {
        $path = __DIR__ . '/defaults/' . $fieldName . '.php';

        if (file_exists($path)) {
            ob_start();
            include $path;
            return ob_get_clean();
        }

        return '';
    }

    public function save($data)
    {
        $dateFields = [
            'analysis_start_date', 'analysis_end_date', 'contract_start_date', 'contract_end_date',
            'loa_date', 'ldo_date', 'ppa_date', 'budget_classification_start_date', 'budget_classification_end_date'
        ];

        foreach ($dateFields as $field) {
            if (!empty($data[$field])) {
                try {
                    $date = new JDate($data[$field], JFactory::getUser()->getTimezone());
                    $data[$field] = $date->toSql(true);
                } catch (Exception $e) {
                    $this->setError(JText::sprintf('JLIB_FORM_VALIDATE_FIELD_INVALID', $field));
                    return false;
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
                if ((int)$consultantId > 0) {
                    $query->values($visitId . ', ' . (int) $consultantId);
                }
            }

            if (!empty($query->getValues())) {
                $db->setQuery($query)->execute();
            }
        }

        return true;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) JFactory::getApplication()->input->getInt('id');

        if ($pk > 0) {
            try {
                $db    = $this->getDbo();
                $query = $db->getQuery(true);

                $query->select('tv.*, c.name AS client_name')
                    ->from($db->quoteName('#__expensemanager_technical_visits', 'tv'))
                    ->join('LEFT', $db->quoteName('#__expensemanager_clients', 'c') . ' ON c.id = tv.client_id')
                    ->where('tv.id = ' . (int) $pk);

                $db->setQuery($query);
                $item = $db->loadObject();

                if ($item) {
                    $query->clear()
                        ->select($db->quoteName('consultant_id'))
                        ->from($db->quoteName('#__expensemanager_technical_visit_consultants'))
                        ->where($db->quoteName('technical_visit_id') . ' = ' . (int) $pk);
                    $db->setQuery($query);
                    $item->consultant_id = $db->loadColumn();

                    if (!empty($item->consultant_id)) {
                        $query->clear()
                            ->select('u.name')
                            ->from($db->quoteName('#__users', 'u'))
                            ->where($db->quoteName('u.id') . ' IN (' . implode(',', $item->consultant_id) . ')');
                        $db->setQuery($query);
                        $item->consultants_details = $db->loadObjectList();
                    } else {
                        $item->consultants_details = array();
                    }
                }

                return $item;
            } catch (Exception $e) {
                $this->setError($e->getMessage());
                return false;
            }
        }

        return new stdClass();
    }
}