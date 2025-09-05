<?php
defined('_JEXEC') or die('Restricted access');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Visita Técnica - <?php echo htmlspecialchars($client_name, ENT_QUOTES, 'UTF-8') ?> - <?php echo htmlspecialchars($report_date, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo JPATH_SITE . '/components/com_expensemanager/assets/css/pdf.css'; ?>">
</head>

<body>
    <div class="background-watermark">
        <?php
        $watermarkImagePath = JPATH_SITE . '/components/com_expensemanager/assets/images/timbrado.jpeg';

        if (file_exists($watermarkImagePath)) {
            $imageData = file_get_contents($watermarkImagePath);
            $imageBase64 = 'data:image/jpeg;base64,' . base64_encode($imageData);
            echo '<img src="' . $imageBase64 . '">';
        }
        ?>
    </div>

    <main>
        <div class="cover">
            <h1>RELATÓRIO DE VISITA TÉCNICA</h1>
            <br><br><br>
        </div>

        <div class="page-break"></div>

        <div class="info-block">
            <div class="label">ENTIDADE</div>
            <div><?php echo htmlspecialchars($client_name, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-block">
            <div class="label">EQUIPE TÉCNICA</div>
            <div><?php echo nl2br(htmlspecialchars($item->consultants_details, ENT_QUOTES, 'UTF-8')); ?></div>
        </div>
        <div class="info-block">
            <div class="label">PERÍODO</div>
            <div><?php echo htmlspecialchars($report_date, ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div class="info-block">
            <div class="label">ATIVIDADES DESENVOLVIDAS:</div>
            <div class="editor-content"><?php echo $item->summary; ?></div>
        </div>

        <div class="page-break"></div>
        <h2>CONSIDERAÇÕES</h2>
        <div class="editor-content">
            <p>
                Em cumprimento as determinações contratuais, especialmente as contidas no contrato <?php echo htmlspecialchars($contract, ENT_QUOTES, 'UTF-8'); ?>,
                processo administrativo <?php echo htmlspecialchars($bidding_process, ENT_QUOTES, 'UTF-8'); ?>,
                foi realizada visita técnica junto a <?php echo htmlspecialchars($client_name, ENT_QUOTES, 'UTF-8'); ?>,
                no período de <?php echo htmlspecialchars($visit_period_start, ENT_QUOTES, 'UTF-8'); ?> a <?php echo htmlspecialchars($visit_period_end, ENT_QUOTES, 'UTF-8'); ?>, sendo realizadas as seguintes atividades e análises:
            </p>
        </div>

        <?php if ($item->section_budget_management_enabled) : ?>
            <div class="page-break"></div>
            <h2>Gestão Orçamentária</h2>

            <div class="editor-content">
                <p>
                    A Lei Orçamentária Anual nº <?php echo htmlspecialchars($item->loa_number, ENT_QUOTES, 'UTF-8'); ?>, de <?php echo htmlspecialchars($loa_date_formatted, ENT_QUOTES, 'UTF-8'); ?>
                    estimou a receita e fixou a despesa para o exercício de <?php echo htmlspecialchars($item->reference_year, ENT_QUOTES, 'UTF-8'); ?>
                    do <?php echo htmlspecialchars($client_name, ENT_QUOTES, 'UTF-8'); ?>, sendo fixada a despesa do <?php echo htmlspecialchars($item->budget_expense_entity, ENT_QUOTES, 'UTF-8'); ?>
                    em <?php echo htmlspecialchars($budget_fixed_expense_formatted, ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($item->budget_fixed_expense_text, ENT_QUOTES, 'UTF-8'); ?>).
                </p>
            </div>

            <?php if ($item->budget_expense_realization_enabled) : ?>
                <h3>Da Realização da Despesa</h3>
                <div class="editor-content">
                    <p>
                        O Orçamento é o instrumento de planejamento de qualquer entidade, pública ou privada, e representa o Fluxo de ingressos e aplicações de recursos em determinado período. Abaixo apresentamos a posição atual do Município em relação a suas despesas.
                    </p>
                    <?php echo $item->budget_expense_realization_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->budget_revenue_collection_enabled) : ?>
                <h3>Da Arrecadação e Previsão de Arrecadação para o Poder Executivo</h3>
                <div class="editor-content">
                    <p>
                        Análise relativo a arrecadação de receitas municipais e a previsão das metas bimestrais, vejamos nos quadros abaixo:
                    </p>
                    <?php echo $item->budget_revenue_collection_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->budget_art167a_compliance_enabled) : ?>
                <h3>Cumprimento do Artigo 167-A</h3>
                <div class="editor-content">
                    <p>
                        Análise do cumprimento do artigo 167-A da CF/88 introduzido pela Emenda Constitucional nº 109/2021, que estabelece medidas de controle de despesas e ajuste fiscal, com o objetivo de garantir a responsabilidade na gestão financeira dos entes públicos. Vejamos a apuração:
                    </p>
                    <?php echo $item->budget_art167a_compliance_notes; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($item->section_budget_classification_enabled) : ?>
            <div class="page-break"></div>
            <h2>Classificação Orçamentária</h2>

            <div class="editor-content">
                <?php if ($item->budget_classification_transfers_enabled) : ?>
                    <p>
                        Análise por amostragem da classificação das transferências orçamentárias, correspondentes a Secretaria do Tesouro Nacional, Ministério do Desenvolvimento Social, Fundo Nacional de Saúde, Fundo Nacional de Desenvolvimento da Educação e Secretaria de Estado da Fazenda de Minas Gerais relativa aos meses de <?php echo htmlspecialchars($start_month_name_bc, ENT_QUOTES, 'UTF-8'); ?> até <?php echo htmlspecialchars($end_date_formatted_bc, ENT_QUOTES, 'UTF-8'); ?>.
                    </p>
                <?php endif; ?>

                <?php if ($item->budget_classification_fundeb_enabled) : ?>
                    <p>
                        Análise por amostragem das receitas referentes às transferências constitucionais bem como seus respectivos redutores financeiros do FUNDEB.
                    </p>
                <?php endif; ?>

                <?php echo $item->budget_classification_notes; ?>
            </div>
        <?php endif; ?>

        <?php if ($item->section_duodecimo_calculation_enabled) : ?>
            <div class="page-break"></div>
            <h2>Apuração do Duodécimo</h2>

            <?php if ($item->duodecimo_art29a_calc_enabled) : ?>
                <h3>Apuração Art. 29-A</h3>
                <div class="editor-content">
                    <p>
                        Conforme disposto no caput do artigo 29-A da CF/88, o duodécimo da Câmara de Vereadores é composto pelo somatório da receita tributária e das transferências previstas no §5º do art. 153 e nos arts. 158 e 159 da CF/88, efetivamente realizadas no exercício anterior. Para fins de aplicação dos limites previstos no art. 29-A, procedemos à apuração das receitas efetivamente arrecadadas pelo município no exercício anterior, tendo como referência de dados o portal fiscalizando com o TCE e do sistema operacional utilizado no município, vejamos:
                    </p>
                    <?php echo $item->duodecimo_art29a_calc_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->duodecimo_transfer_calc_enabled) : ?>
                <h3>Apuração Repasse de Duodécimo</h3>
                <div class="editor-content">
                    <p>
                        Conforme previsto no artigo 168 da CF/88, onde está estabelecido que os recursos proporcionais às dotações orçamentárias fixadas na Lei Orçamentária Anual nº <?php echo htmlspecialchars($item->loa_number, ENT_QUOTES, 'UTF-8'); ?>, de <?php echo htmlspecialchars($loa_date_formatted, ENT_QUOTES, 'UTF-8'); ?>, devem ser entregues até o dia 20 de cada mês, divididos em duodécimos (1/12 Avos do valor da receita prevista para o orçamento), os repasses <?php echo htmlspecialchars($duodecimo_transfer_made_text, ENT_QUOTES, 'UTF-8'); ?> foram realizados mensalmente, totalizando <?php echo htmlspecialchars($duodecimo_transfer_total_formatted, ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($item->duodecimo_transfer_total_text, ENT_QUOTES, 'UTF-8'); ?>), assegurando a autonomia administrativa e financeira do Poder Legislativo. Constatamos ainda que <?php echo htmlspecialchars($duodecimo_refund_made_text, ENT_QUOTES, 'UTF-8'); ?> devolução de numerário para o executivo nos meses de <?php echo htmlspecialchars($item->duodecimo_refund_months_range, ENT_QUOTES, 'UTF-8'); ?>, conforme demonstrativo das transferências financeiras em anexo. Já em relação aos valores, consta o seguinte:
                    </p>
                    <?php echo $item->duodecimo_transfer_calc_notes; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($item->section_constitutional_indices_enabled) : ?>
            <div class="page-break"></div>
            <h2>Da Apuração dos Índices Constitucionais</h2>

            <?php if ($item->indices_education_25_enabled) : ?>
                <h3>Aplicação na Manutenção do Ensino 25%</h3>
                <div class="editor-content">
                    <p>
                        Considerando-se o disposto na “Instrução Normativa nº 02/2021, do Tribunal de Contas do Estado de Minas Gerais”, atualizada pela INTCE nº 01/2023, sobre a aplicação de recursos provenientes da arrecadação de impostos e das transferências constitucionais na manutenção e desenvolvimento do ensino público, analisamos as despesas realizadas na Função 12 - Educação e a efetiva receita resultante de impostos e transferências, em conformidade com os Demonstrativos da Aplicação na Manutenção e Desenvolvimento do Ensino – RREO, até o mês de <?php echo htmlspecialchars($education_until_date_formatted, ENT_QUOTES, 'UTF-8'); ?>.
                    </p>
                    <?php echo $item->indices_education_25_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_fundeb_application_enabled) : ?>
                <h3>Análise quanto a aplicação dos recursos do FUNDEB</h3>
                <div class="editor-content">
                    <p>
                        O Anexo VIII Fundo de Manutenção e Desenvolvimento da Educação Básica e a Valorização dos Profissionais da Educação – FUNDEB, emitido pelo sistema operacional utilizado no Município, aponta os seguintes resultados:
                    </p>
                    <?php echo $item->indices_fundeb_application_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_art212a_chart_enabled) : ?>
                <h3>Quadro Complementar com Indicadores (Art. 212-A)</h3>
                <div class="editor-content">
                    <?php echo $item->indices_art212a_chart_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_health_spending_enabled) : ?>
                <h3>Aplicação nas Ações e Serviços Públicos de Saúde</h3>
                <div class="editor-content">
                    <p>
                        No que se refere à aplicação dos recursos mínimos destinados ao financiamento das Ações e Serviços Públicos de Saúde, fundamentados nas diretrizes estabelecidas pela Instrução Normativa do Tribunal de Contas do Estado de Minas Gerais nº 19/2008, atualizada pela INTCE nº 05/2012, analisamos o relatório das despesas realizadas pelo Município, na Função 10 - Saúde e a efetiva receita, resultante de impostos e transferências, em conformidade com os Anexos IV – Demonstrativos da Aplicação nas Ações e Serviços Públicos de Saúde, emitido pelo sistema operacional utilizado pelo Município, apresentando a seguinte situação:
                    </p>
                    <?php echo $item->indices_health_spending_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_personnel_expenses_enabled) : ?>
                <h3>Apuração da Despesa Total com Pessoal</h3>
                <div class="editor-content">
                    <p>
                        Apuração da despesa Total com Pessoal do Poder Executivo em consonância com o Art. 20, incisos I,II, III da LRF, apresentando a seguinte situação:
                    </p>
                    <?php echo $item->indices_personnel_expenses_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_surplus_usage_enabled) : ?>
                <h3>Utilização de Superávit e Excesso de Arrecadação</h3>
                <div class="editor-content">
                    <p>
                        Analisamos a utilização dos créditos adicionais abertos com recursos provenientes de excesso de arrecadação e superávit no exercício.
                    </p>
                    <?php echo $item->indices_surplus_usage_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_certificate_regularity_enabled) : ?>
                <h3>Regularidade das Certidões Municipais</h3>
                <div class="editor-content">
                    <p>
                        Analise quanto a regularidade das Certidões Municipais junto ao CAUC, CAGEC, RFB, SICONF, SADIPEM, FGTS, Trabalhista.
                    </p>
                    <?php echo $item->indices_certificate_regularity_notes; ?>
                </div>
            <?php endif; ?>

            <?php if ($item->indices_financial_availability_enabled) : ?>
                <h3>Das Disponibilidades Financeiras e da Inscrição de Restos a Pagar</h3>
                <div class="editor-content">
                    <p>
                        Consultoria relativa a disponibilidade financeira Municipal. De acordo com o Demonstrativo de Disponibilidade de Caixa e Bancos e com a Relação de Empenhos a Pagar emitidos pelo sistema operacional até a data desta análise, foram observados os valores compromissados com a inscrição de restos a pagar dos exercícios anteriores (<?php echo htmlspecialchars($item->indices_financial_processed_years, ENT_QUOTES, 'UTF-8'); ?> e <?php echo htmlspecialchars($item->indices_financial_unprocessed_years, ENT_QUOTES, 'UTF-8'); ?>) e do exercício atual, além dos devedores diversos pelo Poder Executivo, a seguir exibiremos quadro detalhando a referida composição:
                    </p>
                    <?php echo $item->indices_financial_availability_notes; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </main>
</body>

</html>