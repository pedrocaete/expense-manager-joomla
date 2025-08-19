<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class ExpenseManagerViewTechnicalvisits extends JViewLegacy
{
    public function display($tpl = null)
    {
        $fpdfPath = JPATH_ADMINISTRATOR . '/components/com_expensemanager/libraries/fpdf/fpdf.php';

        if (!file_exists($fpdfPath)) {
            JFactory::getApplication()->enqueueMessage('Erro: A biblioteca FPDF não foi encontrada.', 'error');
            return false;
        }
        require_once $fpdfPath;

        $this->items = $this->get('Items');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);

        $convertToFPDF = function($string) {
            return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        };

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $convertToFPDF('Relatório de Visitas Técnicas'), 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
        $pdf->Cell(30, 8, $convertToFPDF('Data da Visita'), 1, 0, 'C', true);
        $pdf->Cell(70, 8, $convertToFPDF('Cliente'), 1, 0, 'C', true);
        $pdf->Cell(75, 8, $convertToFPDF('Consultores Associados'), 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 9);

        if (empty($this->items))
        {
            $pdf->Cell(190, 10, $convertToFPDF('Nenhuma visita técnica encontrada.'), 1, 1, 'C');
        }
        else
        {
            foreach ($this->items as $item)
            {
                $pdf->Cell(15, 7, $item->id, 1, 0, 'C');
                $pdf->Cell(30, 7, JHtml::_('date', $item->visit_date, 'd/m/Y'), 1, 0, 'C');
                $pdf->Cell(70, 7, $convertToFPDF($item->client_name), 1, 0, 'L');
                $pdf->Cell(75, 7, $convertToFPDF($item->consultants), 1, 1, 'L');
            }
        }

        $pdf->Output('I', 'relatorio_visitas_' . date('Y-m-d') . '.pdf');

        JFactory::getApplication()->close();
    }
}