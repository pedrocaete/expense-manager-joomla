<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_expensemanager
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

// Acesso restrito
defined('_JEXEC') or die;

/**
 * Helper do componente ExpenseManager.
 */
class ExpenseManagerHelper
{
    /**
     * Configura a barra de links e verifica as permissões.
     *
     * @param   int  $itemId  O ID do item (opcional).
     *
     * @return  JObject  Um objeto com as permissões do usuário.
     */
    public static function getActions($itemId = 0)
    {
        $user      = JFactory::getUser();
        $result    = new JObject;
        $assetName = 'com_expensemanager';

        // Se um ID de item for passado, construímos o asset específico
        // Ex: com_expensemanager.city.1
        if (!empty($itemId)) {
            $assetName .= '.city.' . (int) $itemId;
        }

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    /**
     * Formata um valor numérico como moeda (Real Brasileiro por padrão).
     *
     * @param   float   $value             O valor a ser formatado.
     * @param   string  $currencySymbol    O símbolo da moeda.
     * @param   string  $decimalSeparator  O separador de decimais.
     * @param   string  $thousandSeparator O separador de milhares.
     *
     * @return  string  O valor formatado como moeda.
     */
    public static function formatCurrency($value, $currencySymbol = 'R$', $decimalSeparator = ',', $thousandSeparator = '.')
    {
        if (!is_numeric($value)) {
            $value = 0;
        }

        $formattedValue = number_format((float) $value, 2, $decimalSeparator, $thousandSeparator);

        return $currencySymbol . ' ' . $formattedValue;
    }

    /**
     * Registra uma ação administrativa no log de ações do usuário do Joomla.
     * Requer que o plugin "Usuários - Log de Ações" esteja habilitado.
     *
     * @param   string  $actionContext  Ex: 'city.save', 'consultant.delete'.
     * @param   string  $itemTitle      O título do item que sofreu a ação.
     * @param   int     $itemId         O ID do item.
     *
     * @return  void
     */
    public static function logAction($actionContext, $itemTitle, $itemId)
    {
        // Garante que a API de logs de ação está disponível
        if (!class_exists('JUserActionLog')) {
             JLoader::import('joomla.log.log');
        }

        $user = JFactory::getUser();
        
        $logEntry = array(
            'user_id'     => $user->id,
            'user_username' => $user->username,
            'type'        => JText::_('COM_EXPENSEMANAGER'), // Usando o título do componente
            'message'     => JText::sprintf('COM_EXPENSEMANAGER_LOG_ACTION_MESSAGE', $actionContext, $itemTitle, $itemId),
            'item_id'     => (int) $itemId,
            'extension'   => 'com_expensemanager'
        );

        JUserActionLog::addLog($logEntry);
    }

    /**
     * Adiciona os submenus do componente à barra lateral.
     *
     * @param   string  $vName  O nome da view ativa.
     *
     * @return  void
     */
    public static function addSubmenu($vName = '')
    {
        JHtmlSidebar::addEntry(
            JText::_('COM_EXPENSEMANAGER_SUBMENU_CITIES'),
            'index.php?option=com_expensemanager&view=cities',
            $vName == 'cities'
        );

        JHtmlSidebar::addEntry(
            JText::_('COM_EXPENSEMANAGER_SUBMENU_CONSULTANTS'),
            'index.php?option=com_expensemanager&view=consultants',
            $vName == 'consultants'
        );

        JHtmlSidebar::addEntry(
            JText::_('COM_EXPENSEMANAGER_SUBMENU_CLIENTS'),
            'index.php?option=com_expensemanager&view=clients',
            $vName == 'clients'
        );

    }
}