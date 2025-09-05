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

        ob_start();

        include(JPATH_COMPONENT_SITE . '/views/technicalvisit/tmpl/pdf_layout.php');
        
        $html = ob_get_contents();
        ob_end_clean();

        try {
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'Helvetica');

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
}
