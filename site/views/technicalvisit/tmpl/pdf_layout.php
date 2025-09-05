<?php
defined('_JEXEC') or die('Restricted access');
$item = $this->item;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita Técnica</title>
    <style>
        @page {
            margin: 3cm 2cm 3cm 2cm;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header, .footer {
            position: fixed;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
        }
        .header {
            top: -2.5cm;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .footer {
            bottom: -2.5cm;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
        .cover {
            text-align: center;
            padding-top: 150px;
        }
        .cover h1 {
            font-size: 24px;
        }
        .cover h2 {
            font-size: 16px;
            font-weight: normal;
        }
        h1, h2, h3 {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
        }
        h1 { font-size: 16px; text-transform: uppercase; font-weight: bold; }
        h2 { font-size: 14px; text-transform: uppercase; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 25px; margin-bottom: 15px;}
        h3 { font-size: 12px; font-weight: bold; margin-bottom: 5px; }
        .info-block { margin-bottom: 20px; }
        .info-block .label { font-weight: bold; }
        .editor-content { margin-top: 10px; }
        .editor-content table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        .editor-content th, .editor-content td { border: 1px solid #ddd; padding: 5px; }
        .editor-content th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SAGP - Soluções Administrativas Para Gestão Pública</h1>
    </div>

    <div class="footer">
        CONTATO: 31 97330.7980 | 31 97137.2039 | 31 99818.0697 EMAIL: SAGP.GESTAO@GMAIL.COM<br>
        SAGP SOLUÇÕES ADMINISTRATIVAS PARA GESTÃO PÚBLICA LTDA | CNPJ: 36.897.229/0001-18<br>
        RUA MINISTRO OLIVEIRA SALAZAR 580, APT 306, SANTA MONICA, BELO HORIZONTE/MG 31525-000
    </div>

    <main>
        <div class="cover">
            <h1>RELATÓRIO DE VISITA TÉCNICA</h1>
            <br><br><br>
            <h2><?php echo htmlspecialchars($item->client_name, ENT_QUOTES, 'UTF-8'); ?></h2>
            <br>
            <h2><?php echo JHtml::_('date', $item->analysis_end_date, 'F \d\e Y'); ?></h2>
        </div>

        <div class="page-break"></div>

        <div class="info-block">
            <div class="label">ENTIDADE</div>
            <div><?php echo htmlspecialchars($item->client_name, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-block">
            <div class="label">EQUIPE TÉCNICA</div>
            <div><?php echo nl2br(htmlspecialchars($item->consultants_details, ENT_QUOTES, 'UTF-8')); ?></div>
        </div>
        <div class="info-block">
            <div class="label">PERÍODO</div>
            <div>De <?php echo JHtml::_('date', $item->analysis_start_date, 'd/m/Y'); ?> a <?php echo JHtml::_('date', $item->analysis_end_date, 'd/m/Y'); ?></div>
        </div>
        <div class="info-block">
            <div class="label">ATIVIDADES DESENVOLVIDAS:</div>
            <div class="editor-content"><?php echo $item->summary; ?></div>
        </div>
        <div class="info-block">
            <div class="label">ASSINATURA DO RELATÓRIO:</div>
            <div><?php echo htmlspecialchars($item->report_signer_name, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        
        <?php if ($item->section_budget_management_enabled): ?>
            <div class="page-break"></div>
            <h2>Seção 2: Gestão Orçamentária</h2>
            <?php if ($item->budget_expense_realization_enabled): ?>
                <h3>Da Realização da Despesa</h3>
                <div class="editor-content"><?php echo $item->budget_expense_realization_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->budget_revenue_collection_enabled): ?>
                <h3>Da Arrecadação e Previsão de Arrecadação</h3>
                <div class="editor-content"><?php echo $item->budget_revenue_collection_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->budget_art167a_compliance_enabled): ?>
                <h3>Cumprimento do Artigo 167-A</h3>
                <div class="editor-content"><?php echo $item->budget_art167a_compliance_notes; ?></div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($item->section_budget_classification_enabled): ?>
            <div class="page-break"></div>
            <h2>Seção 3: Classificação Orçamentária</h2>
            <div class="editor-content"><?php echo $item->budget_classification_notes; ?></div>
        <?php endif; ?>

        <?php if ($item->section_duodecimo_calculation_enabled): ?>
            <div class="page-break"></div>
            <h2>Seção 4: Apuração do Duodécimo</h2>
            <?php if ($item->duodecimo_art29a_calc_enabled): ?>
                <h3>Apuração Art. 29-A</h3>
                <div class="editor-content"><?php echo $item->duodecimo_art29a_calc_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->duodecimo_transfer_calc_enabled): ?>
                <h3>Apuração Repasse de Duodécimo</h3>
                <div class="editor-content"><?php echo $item->duodecimo_transfer_calc_notes; ?></div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($item->section_constitutional_indices_enabled): ?>
            <div class="page-break"></div>
            <h2>Seção 5: Apuração dos Índices Constitucionais</h2>
            <?php if ($item->indices_education_25_enabled): ?>
                <h3>Aplicação no Ensino 25%</h3>
                <div class="editor-content"><?php echo $item->indices_education_25_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_fundeb_application_enabled): ?>
                <h3>Aplicação de Recursos do FUNDEB</h3>
                <div class="editor-content"><?php echo $item->indices_fundeb_application_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_art212a_chart_enabled): ?>
                <h3>Quadro Complementar (Art. 212-A)</h3>
                <div class="editor-content"><?php echo $item->indices_art212a_chart_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_health_spending_enabled): ?>
                <h3>Aplicação em Saúde</h3>
                <div class="editor-content"><?php echo $item->indices_health_spending_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_personnel_expenses_enabled): ?>
                <h3>Despesa com Pessoal</h3>
                <div class="editor-content"><?php echo $item->indices_personnel_expenses_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_surplus_usage_enabled): ?>
                <h3>Utilização de Superávit</h3>
                <div class="editor-content"><?php echo $item->indices_surplus_usage_notes; ?></div>
            <?php endif; ?>
             <?php if ($item->indices_certificate_regularity_enabled): ?>
                <h3>Regularidade das Certidões</h3>
                <div class="editor-content"><?php echo $item->indices_certificate_regularity_notes; ?></div>
            <?php endif; ?>
            <?php if ($item->indices_financial_availability_enabled): ?>
                <h3>Disponibilidades Financeiras</h3>
                <div class="editor-content"><?php echo $item->indices_financial_availability_notes; ?></div>
            <?php endif; ?>
        <?php endif; ?>

    </main>
</body>
</html>
