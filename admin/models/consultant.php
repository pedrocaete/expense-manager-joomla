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

/**
 * Model para Consultor Individual
 * 
 * Este é um "Admin Model" - usado para operações CRUD em um registro específico.
 * Herda de JModelAdmin que já tem funcionalidades para:
 * - Carregar um registro específico
 * - Salvar dados
 * - Deletar
 * - Sistema de checkout
 */
class ExpenseManagerModelConsultant extends JModelAdmin
{
    /**
     * Define o prefixo das mensagens de texto
     */
    protected $text_prefix = 'COM_EXPENSEMANAGER_CONSULTANT';

    /**
     * Obtém uma instância da JTable correspondente
     */
    public function getTable($type = 'Consultant', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Define a estrutura do formulário usando JForm
     * 
     * @return JForm|boolean JForm object on success, false on failure
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Obtém o formulário base
        $form = $this->loadForm(
            'com_expensemanager.consultant',
            'consultant',
            array('control' => 'jform', 'load_data' => $loadData)
        );

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    /**
     * Carrega dados para preencher o formulário
     * Método chamado automaticamente quando $loadData = true
     */
    protected function loadFormData()
    {
        // Verifica se há dados na sessão (ex: após erro de validação)
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.consultant.data', array());

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Prepara dados antes de salvar
     */
    protected function prepareTable($table)
    {
        // Limpa dados antes de salvar
        $table->name = htmlspecialchars_decode($table->name, ENT_QUOTES);
        $table->email = htmlspecialchars_decode($table->email, ENT_QUOTES);
        $table->phone = htmlspecialchars_decode($table->phone, ENT_QUOTES);
    }
}