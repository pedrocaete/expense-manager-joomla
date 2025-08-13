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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
    // Ativa a funcionalidade de arrastar e soltar do Joomla
    $saveOrderingUrl = 'index.php?option=com_expensemanager&task=expenses.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'expenseList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>

<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=expenses'); ?>" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else : ?>
    <div id="j-main-container">
    <?php endif; ?>

        <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

        <?php if (empty($this->items)) : ?>
            <div class="alert alert-no-items">
                <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>
            <table class="table table-striped" id="expenseList">
                <thead>
                    <tr>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_DESCRIPTION', 'a.description', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_CONSULTANT', 'consultant_name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_CLIENT', 'client_name', $listDirn, $listOrder); ?>
                        </th>
                         <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_CATEGORY', 'category_name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_AMOUNT', 'a.amount', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_EXPENSE_DATE', 'a.expense_date', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($this->items as $i => $item) :
                    $canChange  = $user->authorise('core.edit.state', 'com_expensemanager');
                    $canEdit    = $user->authorise('core.edit', 'com_expensemanager');
                ?>
                    <tr class="row<?php echo $i % 2; ?>" data-item-id="<?php echo $item->id ?>">
                        <td class="order nowrap center hidden-phone">
                            <?php
                            $iconClass = '';
                            if (!$canChange) {
                                $iconClass = ' inactive';
                            } elseif (!$saveOrder) {
                                $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
                            }
                            ?>
                            <span class="sortable-handler<?php echo $iconClass; ?>">
                                <i class="icon-menu"></i>
                            </span>
                            <?php if ($canChange && $saveOrder) : ?>
                                <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
                            <?php endif; ?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->published, $i, 'expenses.', $canChange, 'cb'); ?>
                        </td>
                        <td class="nowrap has-context">
                            <a href="<?php echo JRoute::_('index.php?option=com_expensemanager&task=expense.edit&id=' . (int) $item->id); ?>">
                                <?php echo $this->escape($item->description); ?>
                            </a>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->consultant_name); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->client_name); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->category_name); ?>
                        </td>
                        <td>
                            <?php echo ExpenseManagerHelper::formatCurrency($item->amount); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo JHtml::_('date', $item->expense_date, JText::_('DATE_FORMAT_LC4')); ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo (int) $item->id; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>