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

/**
 * View para Editar Cidade Individual
 */
class ExpenseManagerViewCity extends JViewLegacy
{
    public $item;
    public $form;
    public $state;

    /**
     * Método principal - prepara e exibe a view
     */
    public function display($tpl = null)
    {
        // Obtém dados do model
        $this->item  = $this->get('Item');
        $this->form  = $this->get('Form');
        $this->state = $this->get('State');

        // Verifica se houve erros
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Adiciona toolbar (barra de botões)
     */
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user       = JFactory::getUser();
        $isNew      = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        $canDo      = ExpenseManagerHelper::getActions();

        // Título da página
        JToolbarHelper::title(
            JText::_(
                'COM_EXPENSEMANAGER_PAGE_' . ($checkedOut ? 'VIEW_CITY' : ($isNew ? 'ADD_CITY' : 'EDIT_CITY'))
            ),
            'location'
        );

        // Se não está em checkout, mostra botões de ação
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create'))))
        {
            JToolbarHelper::apply('city.apply');
            JToolbarHelper::save('city.save');

            if ($canDo->get('core.create'))
            {
                JToolbarHelper::save2new('city.save2new');
            }
        }

        // Botão cancelar
        if (empty($this->item->id))
        {
            JToolbarHelper::cancel('city.cancel');
        }
        else
        {
            JToolbarHelper::cancel('city.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}