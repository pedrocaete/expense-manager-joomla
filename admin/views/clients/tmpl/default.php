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
?>

<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=clients'); ?>" method="post" name="adminForm" id="adminForm">
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
            <table class="table table-striped" id="clientList">
                <thead>
                    <tr>
                        <th width="1%" class="center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('grid.checkall'); ?>
                        </th>
                        <th width="1%" class="center">
                            <?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CLIENT_NAME', 'a.name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CLIENT_CNPJ', 'a.cnpj', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CLIENT_CITY', 'city_name', $listDirn, $listOrder); ?>
                        </th>
                        <th class="nowrap hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', 'COM_EXPENSEMANAGER_CLIENT_CONTACT_PERSON', 'a.contact_person', $listDirn, $listOrder); ?>
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
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="order nowrap center hidden-phone">
                           </td>
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->published, $i, 'clients.', $canChange, 'cb'); ?>
                        </td>
                        <td class="nowrap has-context">
                            <a href="<?php echo JRoute::_('index.php?option=com_expensemanager&task=client.edit&id=' . (int) $item->id); ?>">
                                <?php echo $this->escape($item->name); ?>
                            </a>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->cnpj); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->city_name); ?>
                        </td>
                        <td class="hidden-phone">
                            <?php echo $this->escape($item->contact_person); ?>
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