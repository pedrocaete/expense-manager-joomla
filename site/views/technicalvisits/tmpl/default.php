<?php $pdfUrlAll = JRoute::_('index.php?option=com_expensemanager&view=technicalvisits&format=pdf'); ?>

<div class="technical-visit">
    <h1 class="com_sagp-title"><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_LIST_TITLE'); ?></h1>

    <form action="<?php echo JRoute::_('index.php?option=com_expensemanager&view=technicalvisits'); ?>" method="post" name="adminForm" id="adminForm">
        <div class="list">

            <div class="grid-table header">
                <div>ID</div>
                <div>Data da Visita</div>
                <div>Cliente</div>
                <div>Consultores Associados</div>
                <div class="text-center">Ação</div>
            </div>

            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $item) : ?>
                    <?php
                    $pdfUrlIndividual = JRoute::_('index.php?option=com_expensemanager&view=technicalvisit&id=' . (int) $item->id . '&format=pdf');
                    ?>
                    <div class="grid-table row">
                        <div><?php echo $item->id; ?></div>
                        <div><?php echo JHtml::_('date', $item->visit_date, 'd/m/Y'); ?></div>
                        <div><?php echo $this->escape($item->client_name); ?></div>
                        <div><?php echo $this->escape($item->consultants); ?></div>
                        <div class="text-center">
                            <a href="<?php echo $pdfUrlIndividual; ?>" class="com_sagp-button" target="_blank">
                                <i class="fa fa-download"></i>
                            </a>
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
                <div class="pagination-buttons">

                    <?php if ($this->pagination->pagesCurrent > 1) : ?>
                        <a class="com_sagp-button" href="<?php echo JRoute::_($this->prevUrl); ?>">
                            &laquo;
                        </a>
                    <?php endif; ?>

                    <?php if ($this->pagination->pagesTotal < 5) : ?>
                        <?php for ($page = 1; $page <= $this->pagination->pagesTotal; $page++) : ?>
                            <a class="com_sagp-page-index" href="#">
                                <?php echo $page; ?>
                            </a>
                        <?php endfor; ?>
                    <?php else : ?>
                        <a class="com_sagp-page-index" href="#">1</a>
                        <a class="com_sagp-page-index" href="#">2</a>
                        <span>...</span>
                        <a class="com_sagp-page-index" href="#">
                            <?php echo $this->pagination->pagesTotal - 1; ?>
                        </a>
                        <a class="com_sagp-page-index" href="#">
                            <?php echo $this->pagination->pagesTotal; ?>
                        </a>
                    <?php endif; ?>


                    <?php if ($this->pagination->pagesCurrent < $this->pagination->pagesTotal) : ?>
                        <a class="com_sagp-button" href="<?php echo JRoute::_($this->nextUrl); ?>">
                            &raquo;
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            <div>
                <a href="<?php echo $pdfUrlAll; ?>" target="_blank" class="download-button com_sagp-button">
                    <span class="icon-download" aria-hidden="true"></span>
                    Baixar Relatório Geral
                </a>
            </div>


            <div>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
        </div>
    </form>
</div>