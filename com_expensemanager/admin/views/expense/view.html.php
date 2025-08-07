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

class ExpenseManagerViewExpense extends JViewLegacy
{
    public $item;
    public $form;
    public $state;

    public function display($tpl = null)
    {
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');
        $this->state = $this->get('State');

        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this->addToolbar();

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user       = JFactory::getUser();
        $isNew      = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        $canDo      = ExpenseManagerHelper::getActions();

        JToolbarHelper::title(
            JText::_(
                'COM_EXPENSEMANAGER_PAGE_' . ($checkedOut ? 'VIEW_EXPENSE' : ($isNew ? 'ADD_EXPENSE' : 'EDIT_EXPENSE'))
            ),
            'folder'
        );

        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create'))))
        {
            JToolbarHelper::apply('expense.apply');
            JToolbarHelper::save('expense.save');

            if ($canDo->get('core.create'))
            {
                JToolbarHelper::save2new('expense.save2new');
            }
        }

        if (empty($this->item->id))
        {
            JToolbarHelper::cancel('expense.cancel');
        }
        else
        {
            JToolbarHelper::cancel('expense.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}