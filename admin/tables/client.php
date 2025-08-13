<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerTableClient extends JTable
{
    /**
     * Construtor da tabela
     * 
     * @param JDatabaseDriver $db Database connector object
     */
    public function __construct($db)
    {
        parent::__construct('#__expensemanager_clients', 'id', $db);
        
        $this->_trackAssets = false;
    }

    /**
     * Validação dos dados antes de salvar
     * 
     * @return boolean True se válido, false se inválido
     */
    public function check()
    {
        $this->name           = trim($this->name);
        $this->cnpj           = trim($this->cnpj);
        $this->contact_person = trim($this->contact_person);
        $this->contact_email  = trim($this->contact_email);
        $this->contact_phone  = trim($this->contact_phone);

        if (empty($this->name))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_NAME_REQUIRED'));
            return false;
        }

        if (empty($this->client_type))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_TYPE_REQUIRED'));
            return false;
        }

        if (empty($this->city_id) || !is_numeric($this->city_id) || $this->city_id <= 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_CITY_REQUIRED'));
            return false;
        }

        if (!empty($this->contact_email) && !JMailHelper::isEmailAddress($this->contact_email))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_CONTACT_EMAIL_INVALID'));
            return false;
        }

        return true;
    }

    /**
     * Método executado antes de salvar
     * 
     * @param boolean $updateNulls True para atualizar campos null
     * @return boolean True em caso de sucesso
     */
    public function store($updateNulls = true)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        if (empty($this->id))
        {
            $this->created = $date->toSql();
            $this->created_by = $user->get('id');
        }

        $this->modified = $date->toSql();
        $this->modified_by = $user->get('id');

        if (!isset($this->published))
        {
            $this->published = 1;
        }

        return parent::store($updateNulls);
    }

    /**
     * @param   mixed    $pk  Primary key value.
     * @return  boolean  True se a exclusão for permitida.
     */
    public function delete($pk = null)
    {
        $k  = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;
        $db = $this->getDbo();

        $queryExpenses = $db->getQuery(true)
            ->select('COUNT(id)')
            ->from('#__expensemanager_expenses')
            ->where('client_id = ' . (int) $pk);

        $db->setQuery($queryExpenses);
        if ($db->loadResult())
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_HAS_EXPENSES'));
            return false;
        }

        $queryLinks = $db->getQuery(true)
            ->select('COUNT(id)')
            ->from('#__expensemanager_consultant_clients')
            ->where('client_id = ' . (int) $pk);

        $db->setQuery($queryLinks);
        if ($db->loadResult())
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CLIENT_HAS_LINKS'));
            return false;
        }

        return parent::delete($pk);
    }
}