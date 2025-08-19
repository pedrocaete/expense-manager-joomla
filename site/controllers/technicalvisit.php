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

jimport('joomla.application.component.controllerform');

class ExpenseManagerControllerTechnicalvisit extends JControllerForm
{
    public function save($key = null, $urlVar = 'id')
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app    = JFactory::getApplication();
        $user   = JFactory::getUser();
        $canCreate = $user->authorise('core.create', 'com_expensemanager');

        if (!$canCreate)
        {
            $app->enqueueMessage(JText::_('JLIB_APPLICATION_ERROR_CREATE_RECORD_NOT_PERMITTED'), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_expensemanager&view=technicalvisit', false));
            return false;
        }

        $result = parent::save($key, $urlVar);
        
        $this->setRedirect(
            JRoute::_('index.php?option=com_expensemanager&view=technicalvisit', false),
            $this->message
        );

        return $result;
    }
}