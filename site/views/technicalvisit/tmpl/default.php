<?php
defined('_JEXEC') or die('Restricted access');
?>

<div class="technical-visit">
    <h1 class="com_sagp-title"><?php echo JText::_('COM_EXPENSEMANAGER_TECHNICALVISIT_FORM_TITLE'); ?></h1>

    <form action="<?php echo JRoute::_('index.php?option=com_expensemanager&task=technicalvisit.save'); ?>" method="post" name="adminForm" id="technicalvisit-form" class="form-validate">

        <!-- Bloco Principal -->
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('client_id'); ?>
                    <?php echo $this->form->getInput('client_id'); ?>
                </div>
            </div>
            <div class="form-column">
                 <div class="form-group">
                    <?php echo $this->form->getLabel('consultant_id'); ?>
                    <?php echo $this->form->getInput('consultant_id'); ?>
                </div>
            </div>
        </div>

        <!-- Período de Análise e Referência -->
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('analysis_start_date'); ?>
                    <?php echo $this->form->getInput('analysis_start_date'); ?>
                </div>
                 <div class="form-group">
                    <?php echo $this->form->getLabel('reference_month'); ?>
                    <?php echo $this->form->getInput('reference_month'); ?>
                </div>
            </div>
             <div class="form-column">
                 <div class="form-group">
                    <?php echo $this->form->getLabel('analysis_end_date'); ?>
                    <?php echo $this->form->getInput('analysis_end_date'); ?>
                </div>
                 <div class="form-group">
                    <?php echo $this->form->getLabel('reference_year'); ?>
                    <?php echo $this->form->getInput('reference_year'); ?>
                </div>
            </div>
        </div>

        <!-- Descrições -->
        <div class="form-group">
            <?php echo $this->form->getLabel('description'); ?>
            <?php echo $this->form->getInput('description'); ?>
        </div>
        <div class="form-group-editor">
            <?php echo $this->form->getLabel('personalized_description'); ?>
            <?php echo $this->form->getInput('personalized_description'); ?>
        </div>

        <hr class="form-separator">

        <!-- Detalhes do Contrato -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_CONTRACT_DETAILS_LABEL'); ?></h2>
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('contract_number'); ?>
                    <?php echo $this->form->getInput('contract_number'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('contract_start_date'); ?>
                    <?php echo $this->form->getInput('contract_start_date'); ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('contract_end_date'); ?>
                    <?php echo $this->form->getInput('contract_end_date'); ?>
                </div>
            </div>
        </div>

        <!-- Detalhes da Licitação -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_BIDDING_DETAILS_LABEL'); ?></h2>
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('bidding_process_number'); ?>
                    <?php echo $this->form->getInput('bidding_process_number'); ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('bidding_process_year'); ?>
                    <?php echo $this->form->getInput('bidding_process_year'); ?>
                </div>
            </div>
        </div>

        <!-- Instrumentos Legais -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_LEGAL_INSTRUMENTS_LABEL'); ?></h2>
        <div class="form-columns">
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('loa_number'); ?>
                    <?php echo $this->form->getInput('loa_number'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('ldo_number'); ?>
                    <?php echo $this->form->getInput('ldo_number'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('ppa_number'); ?>
                    <?php echo $this->form->getInput('ppa_number'); ?>
                </div>
            </div>
            <div class="form-column">
                <div class="form-group">
                    <?php echo $this->form->getLabel('loa_date'); ?>
                    <?php echo $this->form->getInput('loa_date'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('ldo_date'); ?>
                    <?php echo $this->form->getInput('ldo_date'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('ppa_date'); ?>
                    <?php echo $this->form->getInput('ppa_date'); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="com_sagp-button validate">
                <span class="icon-ok" aria-hidden="true"></span>
                <?php echo JText::_('COM_EXPENSEMANAGER_SAVE_BUTTON'); ?>
            </button>
        </div>

        <?php echo $this->form->getInput('id'); ?>
        <input type="hidden" name="task" value="technicalvisit.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>