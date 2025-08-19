<?php
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=technicalvisits'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="page-header">
        <h1>Minhas Visitas Técnicas</h1>
    </div>

    <div class="em-form-actions" style="margin-bottom: 20px; text-align: right;">

    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="20%">Data da Visita</th>
                <th>Cliente</th>
                <th>Consultores Associados</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $item) : ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo JHtml::_('date', $item->visit_date, 'd/m/Y'); ?></td>
                        <td><?php echo $this->escape($item->client_name); ?></td>
                        <td><?php echo $this->escape($item->consultants); ?></td>
                        <td> <a href="<?php echo JRoute::_('index.php?option=com_expensemanager&view=technicalvisits&format=pdf'); ?>" class="btn btn-primary">
                                <span class="icon-download" aria-hidden="true"></span>
                                Download PDF
                            </a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="row0">
                    <td colspan="4" class="text-center">
                        Nenhuma visita técnica encontrada.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div>
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>