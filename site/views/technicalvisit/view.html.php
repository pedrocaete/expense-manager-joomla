<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

class ExpenseManagerViewTechnicalvisit extends JViewLegacy
{
    protected $form;
    protected $item;


    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        JFactory::getDocument()->addStyleSheet(JUri::root() . 'components/com_expensemanager/css/style.css');

        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        
        JHtml::_('behavior.formvalidation');
        JHtml::_('behavior.keepalive');
        JHtml::_('formbehavior.chosen', 'select');

        parent::display($tpl);
    }
}