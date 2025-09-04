<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class ExpenseManagerControllerTechnicalvisit extends JControllerForm
{
    public function save($key = null, $urlVar = 'id')
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app   = JFactory::getApplication();
        $model = $this->getModel();
        $form  = $model->getForm();
        $data  = $this->input->post->get('jform', array(), 'array');

        $validData = $model->validate($form, $data);

        if ($validData === false) {
            $errors = $model->getErrors();
            foreach ($errors as $error) {
                $app->enqueueMessage($error, 'error');
            }
            $this->setRedirect(JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $data['id'], false));
            return false;
        }

        if (!$model->save($validData)) {
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $data['id'], false));
            return false;
        }

        $this->setMessage(JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_SAVE_SUCCESS'));

        $recordId = $model->getState($this->context . '.id');

        $this->setRedirect(
            JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . $recordId, false)
        );

        return true;
    }
}
