<?php
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

$pdfUrlAll = JRoute::_('index.php?option=com_expensemanager&view=technicalvisits&format=pdf');
?>
<form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=technicalvisits'); ?>" method="post" name="adminForm" id="adminForm">
    <div class="page-header">
        <h1>Minhas Visitas Técnicas</h1>
    </div>

    <div class="em-form-actions" style="margin-bottom: 20px; text-align: right;">
        <a href="<?php echo $pdfUrlAll; ?>" target="_blank" class="btn btn-info">
            <span class="icon-download" aria-hidden="true"></span>
            Baixar Relatório Geral
        </a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Data da Visita</th>
                <th>Cliente</th>
                <th>Consultores Associados</th>
                <th width="15%" class="text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $item) : ?>
                    <?php
                    $pdfUrlIndividual = JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $item->id . '&format=pdf');
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo JHtml::_('date', $item->visit_date, 'd/m/Y'); ?></td>
                        <td><?php echo $this->escape($item->client_name); ?></td>
                        <td><?php echo $this->escape($item->consultants); ?></td>
                        <td class="text-center">
                            <a href="<?php echo $pdfUrlIndividual; ?>" class="btn btn-primary btn-small" target="_blank">
                                <span class="icon-file" aria-hidden="true"></span>
                                Gerar PDF
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr class="row0">
                    <td colspan="5" class="text-center">
                        Nenhuma visita técnica encontrada.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
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