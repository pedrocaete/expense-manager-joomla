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

        <!-- INÍCIO DAS SEÇÕES DO RELATÓRIO -->

        <!-- Seção 1: Assinatura -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_REPORT_SIGNER_LABEL'); ?></h2>
        <div class="form-group">
            <?php echo $this->form->getLabel('report_signer_name'); ?>
            <?php echo $this->form->getInput('report_signer_name'); ?>
        </div>

        <!-- Seção 2: Gestão Orçamentária -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_BUDGET_MANAGEMENT_LABEL'); ?></h2>
        <div class="form-group">
            <?php echo $this->form->getLabel('section_budget_management_enabled'); ?>
            <?php echo $this->form->getInput('section_budget_management_enabled'); ?>
        </div>
        <div class="section-content-wrapper">
            <div class="form-columns">
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('budget_exercise_year'); ?>
                    <?php echo $this->form->getControlGroup('budget_fixed_expense_value'); ?>
                </div>
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('budget_expense_entity'); ?>
                    <?php echo $this->form->getControlGroup('budget_fixed_expense_text'); ?>
                </div>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('budget_expense_realization_enabled'); ?>
                <?php echo $this->form->getInput('budget_expense_realization_enabled'); ?>
                <?php echo $this->form->getInput('budget_expense_realization_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('budget_revenue_collection_enabled'); ?>
                <?php echo $this->form->getInput('budget_revenue_collection_enabled'); ?>
                <?php echo $this->form->getInput('budget_revenue_collection_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('budget_art167a_compliance_enabled'); ?>
                <?php echo $this->form->getInput('budget_art167a_compliance_enabled'); ?>
                <?php echo $this->form->getInput('budget_art167a_compliance_notes'); ?>
            </div>
        </div>

        <!-- Seção 3: Classificação Orçamentária -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_BUDGET_CLASSIFICATION_LABEL'); ?></h2>
        <div class="form-group">
            <?php echo $this->form->getLabel('section_budget_classification_enabled'); ?>
            <?php echo $this->form->getInput('section_budget_classification_enabled'); ?>
        </div>
        <div class="section-content-wrapper">
            <div class="form-columns">
                <div class="form-column">
                     <?php echo $this->form->getControlGroup('budget_classification_start_date'); ?>
                </div>
                <div class="form-column">
                     <?php echo $this->form->getControlGroup('budget_classification_end_date'); ?>
                </div>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                 <?php echo $this->form->getLabel('budget_classification_transfers_enabled'); ?>
                 <?php echo $this->form->getInput('budget_classification_transfers_enabled'); ?>
            </div>
            <div class="form-group">
                 <?php echo $this->form->getLabel('budget_classification_fundeb_enabled'); ?>
                 <?php echo $this->form->getInput('budget_classification_fundeb_enabled'); ?>
            </div>
            <?php echo $this->form->getInput('budget_classification_notes'); ?>
        </div>

        <!-- Seção 4: Apuração do Duodécimo -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_DUODECIMO_CALCULATION_LABEL'); ?></h2>
        <div class="form-group">
            <?php echo $this->form->getLabel('section_duodecimo_calculation_enabled'); ?>
            <?php echo $this->form->getInput('section_duodecimo_calculation_enabled'); ?>
        </div>
        <div class="section-content-wrapper">
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('duodecimo_art29a_calc_enabled'); ?>
                <?php echo $this->form->getInput('duodecimo_art29a_calc_enabled'); ?>
                <?php echo $this->form->getInput('duodecimo_art29a_calc_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('duodecimo_transfer_calc_enabled'); ?>
                <?php echo $this->form->getInput('duodecimo_transfer_calc_enabled'); ?>
            </div>
            <div class="form-columns">
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('duodecimo_transfer_made'); ?>
                    <?php echo $this->form->getControlGroup('duodecimo_transfer_total_value'); ?>
                    <?php echo $this->form->getControlGroup('duodecimo_refund_made'); ?>
                </div>
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('duodecimo_transfer_until_date'); ?>
                    <?php echo $this->form->getControlGroup('duodecimo_transfer_total_text'); ?>
                    <?php echo $this->form->getControlGroup('duodecimo_refund_months_range'); ?>
                </div>
            </div>
            <?php echo $this->form->getInput('duodecimo_transfer_calc_notes'); ?>
        </div>
        
        <!-- Seção 5: Apuração dos Índices Constitucionais -->
        <h2 class="fieldset-title"><?php echo JText::_('COM_EXPENSEMANAGER_CONSTITUTIONAL_INDICES_LABEL'); ?></h2>
        <div class="form-group">
            <?php echo $this->form->getLabel('section_constitutional_indices_enabled'); ?>
            <?php echo $this->form->getInput('section_constitutional_indices_enabled'); ?>
        </div>
        <div class="section-content-wrapper">
            <div class="form-group">
                 <?php echo $this->form->getLabel('indices_education_until_month_year'); ?>
                 <?php echo $this->form->getInput('indices_education_until_month_year'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_education_25_enabled'); ?>
                <?php echo $this->form->getInput('indices_education_25_enabled'); ?>
                <?php echo $this->form->getInput('indices_education_25_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_fundeb_application_enabled'); ?>
                <?php echo $this->form->getInput('indices_fundeb_application_enabled'); ?>
                <?php echo $this->form->getInput('indices_fundeb_application_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_health_spending_enabled'); ?>
                <?php echo $this->form->getInput('indices_health_spending_enabled'); ?>
                <?php echo $this->form->getInput('indices_health_spending_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_personnel_expenses_enabled'); ?>
                <?php echo $this->form->getInput('indices_personnel_expenses_enabled'); ?>
                <?php echo $this->form->getInput('indices_personnel_expenses_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_surplus_usage_enabled'); ?>
                <?php echo $this->form->getInput('indices_surplus_usage_enabled'); ?>
                <?php echo $this->form->getInput('indices_surplus_usage_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_certificate_regularity_enabled'); ?>
                <?php echo $this->form->getInput('indices_certificate_regularity_enabled'); ?>
                <?php echo $this->form->getInput('indices_certificate_regularity_notes'); ?>
            </div>
            <hr class="form-separator-dashed">
            <div class="form-group">
                <?php echo $this->form->getLabel('indices_financial_availability_enabled'); ?>
                <?php echo $this->form->getInput('indices_financial_availability_enabled'); ?>
            </div>
            <div class="form-columns">
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('indices_financial_processed_years'); ?>
                </div>
                <div class="form-column">
                    <?php echo $this->form->getControlGroup('indices_financial_unprocessed_years'); ?>
                </div>
            </div>
            <?php echo $this->form->getInput('indices_financial_availability_notes'); ?>
        </div>

        <hr class="form-separator">

        <!-- Detalhes do Contrato e Licitação -->
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
                    <?php echo $this->form->getLabel('bidding_process_number'); ?>
                    <?php echo $this->form->getInput('bidding_process_number'); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->form->getLabel('contract_end_date'); ?>
                    <?php echo $this->form->getInput('contract_end_date'); ?>
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