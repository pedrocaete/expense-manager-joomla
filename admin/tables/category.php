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

class ExpenseManagerTableCategory extends JTable
{

    public function __construct($db)
    {
        parent::__construct('#__expensemanager_categories', 'id', $db);
        
        $this->_trackAssets = false;
    }

    public function check()
    {
        $this->name = trim($this->name);

        if (empty($this->name))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CATEGORY_NAME_REQUIRED'));
            return false;
        }

        return true;
    }

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

    public function delete($pk = null)
    {
        $k = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;

        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from('#__expensemanager_expenses')
            ->where('category_id = ' . (int) $pk);
        $db->setQuery($query);
        $count = $db->loadResult();

        if ($count > 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CATEGORY_HAS_EXPENSES'));
            return false;
        }

        return parent::delete($pk);
    }
}