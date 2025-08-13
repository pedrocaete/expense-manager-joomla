<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.3
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerViewExpenses extends JViewLegacy
{
    /**
     * Método display para gerar o PDF.
     */
    public function display($tpl = null)
    {
        $fpdfPath = JPATH_COMPONENT_ADMINISTRATOR . '/libraries/fpdf/fpdf.php';
        if (!file_exists($fpdfPath)) {
            JFactory::getApplication()->enqueueMessage('Erro Crítico: A biblioteca FPDF não foi encontrada.', 'error');
            return false;
        }
        require_once $fpdfPath;

        if (!function_exists('mb_convert_encoding')) {
            JFactory::getApplication()->enqueueMessage('A extensão PHP "mbstring" é necessária para a exportação de PDF.', 'error');
            return false;
        }

        $this->items = $this->get('Items');
        $this->state = $this->get('State');

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);

        $convertToFPDF = function($string) {
            return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        };

        // Título
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $convertToFPDF('Relatório de Despesas'), 0, 1, 'C');
        $pdf->Ln(10);

        // Cabeçalhos da tabela - Nova estrutura
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(20, 8, $convertToFPDF('Data'), 1, 0, 'C', true);
            $pdf->Cell(25, 8, $convertToFPDF('Nº Nota'), 1, 0, 'C', true);
        $pdf->Cell(30, 8, $convertToFPDF('Consultor'), 1, 0, 'C', true);
        $pdf->Cell(30, 8, $convertToFPDF('Cliente'), 1, 0, 'C', true);
        $pdf->Cell(15, 8, $convertToFPDF('Cat.'), 1, 0, 'C', true);
        $pdf->Cell(20, 8, $convertToFPDF('Valor'), 1, 1, 'C', true);

        // Corpo da tabela
        $pdf->SetFont('Arial', '', 9); // Fonte um pouco menor para caber melhor
        
        if (empty($this->items))
        {
            $pdf->Cell(190, 10, $convertToFPDF('Nenhum item encontrado.'), 1, 1, 'C');
        }
        else
        {
            foreach ($this->items as $item)
            {
                // Dados para as novas colunas
                $date           = JHtml::_('date', $item->expense_date, 'd/m/Y');
                $invoice_number = $convertToFPDF($item->invoice_number);
                $consultant     = $convertToFPDF($item->consultant_name);
                $client         = $convertToFPDF($item->client_name);
                $category       = $convertToFPDF($item->category_name);
                $amount         = $convertToFPDF(ExpenseManagerHelper::formatCurrency($item->amount, 'R$'));

                // Células da tabela com os novos dados
                $pdf->Cell(20, 7, $date, 1, 0, 'C');
                $pdf->Cell(25, 7, $invoice_number, 1, 0, 'L');
                $pdf->Cell(30, 7, $consultant, 1, 0, 'L');
                $pdf->Cell(30, 7, $client, 1, 0, 'L');
                $pdf->Cell(15, 7, $category, 1, 0, 'L');
                $pdf->Cell(20, 7, $amount, 1, 1, 'R');
            }
        }
        
        $pdf->Output('D', 'relatorio_despesas_' . date('Y-m-d') . '.pdf');
        
        JFactory::getApplication()->close();
    }
}