<?php
defined('_JEXEC') or die('Restricted access');

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdfPath = JPATH_ADMINISTRATOR . '/components/com_expensemanager/libraries/dompdf/autoload.inc.php';

if (!file_exists($dompdfPath)) {
    JFactory::getApplication()->enqueueMessage('Erro CRÍTICO: A biblioteca Dompdf nao foi encontrada em /administrator/components/com_expensemanager/libraries/dompdf.', 'error');
    return false;
}
require_once $dompdfPath;

class ExpenseManagerViewTechnicalvisit extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->item = $this->get('Item');

        if (!$this->item || empty($this->item->id)) {
            JFactory::getApplication()->enqueueMessage('Nao foi possivel encontrar a visita tecnica para gerar o PDF.', 'error');
            return;
        }

        $item = $this->item;


        switch ($item->reference_month) {
            case 1:
                $month_name = 'Janeiro';
                break;
            case 2:
                $month_name = 'Fevereiro';
                break;
            case 3:
                $month_name = 'Março';
                break;
            case 4:
                $month_name = 'Abril';
                break;
            case 5:
                $month_name = 'Maio';
                break;
            case 6:
                $month_name = 'Junho';
                break;
            case 7:
                $month_name = 'Julho';
                break;
            case 8:
                $month_name = 'Agosto';
                break;
            case 9:
                $month_name = 'Setembro';
                break;
            case 10:
                $month_name = 'Outubro';
                break;
            case 11:
                $month_name = 'Novembro';
                break;
            case 12:
                $month_name = 'Dezembro';
                break;
            default:
                $month_name = $item->reference_month;
                break;
        }
        $report_date = $month_name . ' de ' . $item->reference_year;

        $contract_year = date('Y', strtotime($item->contract_start_date));
        $contract = $item->contract_number . '/' . $contract_year;
        $client_name = $item->client_name;

        $bidding_process = $item->bidding_process_number . '/' . $item->bidding_process_year;

        $visit_period_start = JHtml::_('date', $item->analysis_start_date, 'd \d\e F');
        $visit_period_end = JHtml::_('date', $item->analysis_end_date, 'd \d\e F \d\e Y');

        $loa_date_formatted = JHtml::_('date', $item->loa_date, 'd \d\e F \d\e Y');
        $budget_fixed_expense_formatted = 'R$ ' . number_format($item->budget_fixed_expense_value, 2, ',', '.');

        $start_month_number_bc = JHtml::_('date', $item->budget_classification_start_date, 'n');
        $start_month_name_bc = '';
        switch ($start_month_number_bc) {
            case 1:
                $start_month_name_bc = 'Janeiro';
                break;
            case 2:
                $start_month_name_bc = 'Fevereiro';
                break;
            case 3:
                $start_month_name_bc = 'Março';
                break;
            case 4:
                $start_month_name_bc = 'Abril';
                break;
            case 5:
                $start_month_name_bc = 'Maio';
                break;
            case 6:
                $start_month_name_bc = 'Junho';
                break;
            case 7:
                $start_month_name_bc = 'Julho';
                break;
            case 8:
                $start_month_name_bc = 'Agosto';
                break;
            case 9:
                $start_month_name_bc = 'Setembro';
                break;
            case 10:
                $start_month_name_bc = 'Outubro';
                break;
            case 11:
                $start_month_name_bc = 'Novembro';
                break;
            case 12:
                $start_month_name_bc = 'Dezembro';
                break;
        }

        $end_date_formatted_bc = JHtml::_('date', $item->budget_classification_end_date, 'F \d\e Y');

        $duodecimo_transfer_made_text = $item->duodecimo_transfer_made ? '' : 'não';
        $duodecimo_refund_made_text = $item->duodecimo_refund_made ? 'fora realizada' : 'não fora realizada';

        $duodecimo_transfer_total_formatted = 'R$ ' . number_format($item->duodecimo_transfer_total_value, 2, ',', '.');

        $education_until_date_formatted = JHtml::_('date', $item->indices_education_until_month_year, 'F \d\e Y');



        ob_start();

        include(JPATH_COMPONENT_SITE . '/views/technicalvisit/tmpl/pdf_layout.php');

        $html = ob_get_contents();
        ob_end_clean();

        try {
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'Helvetica');
            $options->set('chroot', JPATH_SITE); 

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');

            $dompdf->render();
            $dompdf->stream('Relatorio-Visita-Tecnica-' . $this->item->id . '.pdf', array("Attachment" => false));
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage('Erro ao gerar o PDF: ' . $e->getMessage(), 'error');
            return;
        }

        JFactory::getApplication()->close();
    }

    public function prepareItems (){
        
    }
}
