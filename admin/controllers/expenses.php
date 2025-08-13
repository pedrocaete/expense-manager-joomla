<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

class ExpenseManagerControllerExpenses extends JControllerAdmin
{
    protected $text_prefix = 'COM_EXPENSEMANAGER_EXPENSES';

    public function getModel($name = 'Expense', $prefix = 'ExpenseManagerModel', $config = array())
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }

    /**
     * Tarefa para exportar a lista de despesas para um ficheiro PDF.
     *
     * @return  void
     */
    public function exportPdf()
    {
        $document = JFactory::getDocument();

        // A linha crucial: Define o tipo do documento que o Joomla deve renderizar.
        // Isto fará com que o Joomla procure por uma view.pdf.php.
        $document->setType('pdf');

        // A view a ser carregada (expenses) é retirada do request,
        // que já está correto por estarmos na lista de despesas.
        // Deixamos o método display da classe pai fazer o resto do trabalho.
        parent::display();
    }

}