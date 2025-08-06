<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Seu Nome
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerModelClient extends JModelAdmin
{

    protected $text_prefix = 'COM_EXPENSEMANAGER_CLIENT';

    public function getTable($type = 'Client', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * @return JForm|boolean JForm object on success, false on failure
     */
    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            'com_expensemanager.client',
            'client',
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
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.client.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Prepara o objeto da tabela antes de salvar.
     *
     * @param   JTable  $table  O objeto da tabela a ser preparado.
     *
     * @return  void
     */
    protected function prepareTable($table)
    {
        $table->name           = htmlspecialchars_decode($table->name, ENT_QUOTES);
        $table->client_type    = htmlspecialchars_decode($table->client_type, ENT_QUOTES);
        $table->cnpj           = htmlspecialchars_decode($table->cnpj, ENT_QUOTES);
        $table->contact_person = htmlspecialchars_decode($table->contact_person, ENT_QUOTES);
        $table->contact_email  = htmlspecialchars_decode($table->contact_email, ENT_QUOTES);
        $table->contact_phone  = htmlspecialchars_decode($table->contact_phone, ENT_QUOTES);
    }
}