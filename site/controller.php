<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = array())
    {
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'technicalvisits'));

        parent::display($cachable, $urlparams);
    }
}