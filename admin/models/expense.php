<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Seu Nome
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

class ExpenseManagerModelExpense extends JModelAdmin
{

    protected $text_prefix = 'COM_EXPENSEMANAGER_EXPENSE';

    public function getTable($type = 'Expense', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            'com_expensemanager.expense',
            'expense',
            array('control' => 'jform', 'load_data' => $loadData)
        );

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.expense.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    protected function prepareTable($table)
    {
        $table->description    = htmlspecialchars_decode($table->description, ENT_QUOTES);
        $table->invoice_number = htmlspecialchars_decode($table->invoice_number, ENT_QUOTES);
        $table->notes          = htmlspecialchars_decode($table->notes, ENT_QUOTES);
    }
}