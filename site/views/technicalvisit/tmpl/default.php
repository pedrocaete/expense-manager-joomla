<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');
?>

<div class="technical-visit-form">
    <h1><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_FORM_TITLE'); ?></h1>

    <form action="<?php echo JRoute::_('index.php?option=com_expensemanager&task=technicalvisit.save'); ?>" method="post" name="adminForm" id="technicalvisit-form" class="form-validate form-horizontal">

        <fieldset>
            <legend><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_DETAILS_LABEL'); ?></legend>
            <?php foreach ($this->form->getFieldset('details') as $field) : ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $field->label; ?></div>
                    <div class="controls"><?php echo $field->input; ?></div>
                </div>
            <?php endforeach; ?>
        </fieldset>

        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary validate">
                    <?php echo JText::_('COM_EXPENSEMANAGER_SAVE_BUTTON'); ?>
                </button>
            </div>
        </div>

        <input type="hidden" name="task" value="technicalvisit.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>