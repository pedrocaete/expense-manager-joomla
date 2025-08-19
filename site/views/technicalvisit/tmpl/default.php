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
?>

<div class="technical-visit-form">
    <h1><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_FORM_TITLE'); ?></h1>

    <form action="<?php echo JRoute::_('index.php?option=com_expensemanager&task=technicalvisit.save'); ?>" method="post" name="adminForm" id="technicalvisit-form" class="form-validate">
        
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('client_id'); ?>
                    <?php echo $this->form->getInput('client_id'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('consultant_id'); ?>
                    <?php echo $this->form->getInput('consultant_id'); ?>
                </div>
            </div>

            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('visit_date'); ?>
                    <?php echo $this->form->getInput('visit_date'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('description'); ?>
                    <?php echo $this->form->getInput('description'); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="button-save validate">
                <span class="icon-ok" aria-hidden="true"></span>
                <?php echo JText::_('COM_EXPENSEMANAGER_SAVE_BUTTON'); ?>
            </button>
        </div>

        

        <?php echo $this->form->getInput('id'); ?>
        <input type="hidden" name="task" value="technicalvisit.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>