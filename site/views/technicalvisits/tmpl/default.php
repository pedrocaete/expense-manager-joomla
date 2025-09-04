<?php
defined('_JEXEC') or die('Restricted access');
// Adiciona a folha de estilos do Font Awesome para garantir que o ícone de download apareça
JHtml::_('stylesheet', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
?>

<div class="technical-visit">
    <h1 class="com_sagp-title"><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_LIST_TITLE'); ?></h1>

    <form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=technicalvisits'); ?>" method="post" name="adminForm" id="adminForm">
        <div class="list">

            <div class="grid-table header">
                <div>ID</div>
                <div>Data da Análise</div>
                <div>Cliente</div>
                <div>Consultores Associados</div>
                <div class="text-center">Ações</div>
            </div>

            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $item) : ?>
                    <?php
                    // Cria os links para Editar e para o PDF
                    $linkEdit = JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $item->id);
                    $pdfUrlIndividual = JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $item->id . '&format=pdf');
                    ?>
                    <div class="grid-table row">
                        <div><?php echo $item->id; ?></div>
                        <div><?php echo JHtml::_('date', $item->analysis_start_date, 'd/m/Y'); ?></div>
                        <div><?php echo $this->escape($item->client_name); ?></div>
                        <div><?php echo $this->escape($item->consultants); ?></div>
                        <div class="text-center">
                            <a href="<?php echo $linkEdit; ?>" class="com_sagp-button">
                                Editar
                            </a>

                            <?php // --- BOTÃO DE DOWNLOAD ADICIONADO AQUI --- 
                            ?>
                            <a href="<?php echo $pdfUrlIndividual; ?>" class="com_sagp-button" target="_blank" title="Baixar PDF">
                                <i class="fa fa-download"></i>
                            </a>
                            <?php // --- FIM DA ADIÇÃO --- 
                            ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="grid-table empty">
                    <div class="no-data" style="grid-column: 1 / -1; text-align: center;">
                        Nenhuma visita técnica encontrada.
                    </div>
                </div>
            <?php endif; ?>


            <?php if ($this->pagination->pagesTotal > 1) : ?>
                <div class="pagination">
                    <?php echo $this->pagination->getPagesLinks(); ?>
                </div>
            <?php endif; ?>

            <div>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </div>
    </form>
</div>