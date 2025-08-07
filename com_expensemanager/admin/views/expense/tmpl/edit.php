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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

$app = JFactory::getApplication();
$input = $app->input;
?>

<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=expense&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">

    <div class="form-horizontal">

        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset name="details">
                    <?php foreach ($this->form->getFieldset('details') as $field) : ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>

            <div class="span2">
                <h4><?php echo JText::_('JDETAILS'); ?></h4>
                <hr />
                <fieldset class="form-vertical">

                    <div class="control-group">
                        <div class="control-label">
                            <?php echo $this->form->getLabel('id'); ?>
                        </div>
                        <div class="controls">
                            <?php echo $this->form->getInput('id'); ?>
                        </div>
                    </div>

                    <?php if ($this->item->created) : ?>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo JText::_('JGLOBAL_FIELD_CREATED_LABEL'); ?>
                            </div>
                            <div class="controls">
                                <?php echo JHtml::_('date', $this->item->created, JText::_('DATE_FORMAT_LC2')); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->item->modified) : ?>
                        <div class="control-group">
                            <div class="control-label">
                                <?php echo JText::_('JGLOBAL_FIELD_MODIFIED_LABEL'); ?>
                            </div>
                            <div class="controls">
                                <?php echo JHtml::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2')); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </fieldset>
            </div>
        </div>

    </div>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>