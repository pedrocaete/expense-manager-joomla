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
    /**
     * Tarefa de exibição padrão.
     *
     * @param   boolean  $cachable   Se true, a view pode ser cacheada.
     * @param   array    $urlparams  Array de parâmetros de URL seguros.
     *
     * @return  void
     */
    public function display($cachable = false, $urlparams = array())
    {
        // Define a view padrão para a lista (plural) se nenhuma for especificada na URL
        $input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'technicalvisits'));

        parent::display($cachable, $urlparams);
    }
}