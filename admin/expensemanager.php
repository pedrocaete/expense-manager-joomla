<?php
/**
 * @package     ExpenseManager
 * @subpackage  Administrator
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Proteção contra acesso direto
defined('_JEXEC') or die('Restricted access');

// Inclui bibliotecas necessárias do Joomla
JLoader::register('ExpenseManagerHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/expensemanager.php');

// ADICIONE ESTA LINHA: Registra o caminho para os formulários
JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/forms');

// Verifica permissões básicas
if (!JFactory::getUser()->authorise('core.manage', 'com_expensemanager'))
{
    throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

// Obtém instância do controller
$controller = JControllerLegacy::getInstance('ExpenseManager');

// Executa a task solicitada
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redireciona se necessário
$controller->redirect();