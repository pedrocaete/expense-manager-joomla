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

class ExpenseManagerControllerExpense extends JControllerForm
{

    protected $text_prefix = 'COM_EXPENSEMANAGER_EXPENSE';

    protected function getRedirectToListAppend()
    {
        $append = parent::getRedirectToListAppend();
        return $append;
    }

    protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
    {
        $append = parent::getRedirectToItemAppend($recordId, $urlVar);
        return $append;
    }
}