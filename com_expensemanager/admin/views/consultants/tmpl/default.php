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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$canOrder  = $user->authorise('core.edit.state', 'com_expensemanager');
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_expensemanager&task=consultants.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'consultantList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=consultants'); ?>" method="post" name="adminForm" id="adminForm">
    
    <?php if (!empty( $this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <?php else : ?>
    <div id="j-main-container">
    <?php endif;?>
        
        <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>
        
        <?php if (empty($this->items)) : ?>
            <div class="alert alert-no-items">
                <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
            </div>
        <?php else : ?>
            
            <table class="table table-striped" id="consultantList">
                <thead>
                    <tr>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th width="1%" style="min-width:55px" class="nowrap center">
                            <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CONSULTANT_NAME', 'a.name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CONSULTANT_EMAIL', 'a.email', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CONSULTANT_PHONE', 'a.phone', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_CREATED_BY', 'a.created_by', $listDirn, $listOrder); ?>
                        </th>
                        <th width="10%" class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'JDATE', 'a.created', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($this->items as $i => $item) :
                    $ordering   = ($listOrder == 'a.ordering');
                    $canCreate  = $user->authorise('core.create', 'com_expensemanager');
                    $canEdit    = $user->authorise('core.edit', 'com_expensemanager');
                    $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
                    $canChange  = $user->authorise('core.edit.state', 'com_expensemanager') && $canCheckin;
                ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="order nowrap center hidden-phone">
                            <?php
                            $iconClass = '';
                            if (!$canChange)
                            {
                                $iconClass = ' inactive';
                            }
                            elseif (!$saveOrder)
                            {
                                $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
                            }
                            ?>
                            <span class="sortable-handler<?php echo $iconClass ?>">
                                <span class="icon-menu" aria-hidden="true"></span>
                            </span>
                            <?php if ($canChange && $saveOrder) : ?>
                                <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
                            <?php endif; ?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center">
                            <div class="btn-group">
                                <?php echo JHtml::_('jgrid.published', $item->published, $i, 'consultants.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
                            </div>
                        </td>
                        <td class="nowrap has-context">
                            <div class="pull-left">
                                <?php if ($item->checked_out) : ?>
                                    <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'consultants.', $canCheckin); ?>
                                <?php endif; ?>
                                <?php if ($canEdit) : ?>
                                    <a href="<?php echo JRoute::_('index.php?option=com_expensemanager&task=consultant.edit&id=' . (int) $item->id); ?>">
                                        <?php echo $this->escape($item->name); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo $this->escape($item->name); ?>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->email); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->phone); ?>
                        </td>
                        <td class="nowrap small hidden-phone">
                            <?php echo $this->escape($item->created_by_name); ?>
                        </td>
                        <td class="nowrap small hidden-phone">
                            <?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
                        </td>
                        <td class="nowrap small hidden-phone">
                            <?php echo (int) $item->id; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            
            <?php echo $this->pagination->getListFooter(); ?>
            
        <?php endif; ?>

        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>