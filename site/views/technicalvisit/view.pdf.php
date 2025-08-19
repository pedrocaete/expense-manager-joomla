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

class ExpenseManagerViewTechnicalvisit extends JViewLegacy
{
    public function display($tpl = null)
    {
        $this->item = $this->get('Item');

        if (!$this->item || !$this->item->id) {
            JFactory::getApplication()->enqueueMessage('Não foi possível encontrar a visita técnica.', 'error');
            return false;
        }
        
        $fpdfPath = JPATH_ADMINISTRATOR . '/components/com_expensemanager/libraries/fpdf/fpdf.php';
        require_once $fpdfPath;

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $convertToFPDF = function($string) {
            return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        };

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->Cell(0, 12, $convertToFPDF('Relatório de Visita Técnica'), 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 8, $convertToFPDF('Cliente:'), 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, $convertToFPDF($this->item->client_name), 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 8, $convertToFPDF('Data da Visita:'), 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, JHtml::_('date', $this->item->visit_date, 'd/m/Y'), 0, 1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(40, 8, $convertToFPDF('Consultor(es):'), 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, $convertToFPDF($this->item->consultants), 0, 1);
        $pdf->Ln(8);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, $convertToFPDF('Descrição das Atividades:'), 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 8, $convertToFPDF($this->item->description), 1, 'L');

        ob_end_clean();
        $pdf->Output('I', 'visita_tecnica_' . $this->item->id . '.pdf');
        JFactory::getApplication()->close();
    }
}