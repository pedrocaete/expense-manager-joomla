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

/**
 * Controller para Consultor Individual
 * 
 * Gerencia operações em um Consultor específico:
 * - Salvar
 * - Cancelar edição
 * - Aplicar (salvar e continuar editando)
 */
class ExpenseManagerControllerConsultant extends JControllerForm
{
    /**
     * Define o prefixo das mensagens de texto
     */
    protected $text_prefix = 'COM_EXPENSEMANAGER_CONSULTANT';

    /**
     * Define para onde redirecionar após salvar
     */
    protected function getRedirectToListAppend()
    {
        $append = parent::getRedirectToListAppend();
        return $append;
    }

    /**
     * Define para onde redirecionar após salvar um item
     */
    protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
    {
        $append = parent::getRedirectToItemAppend($recordId, $urlVar);
        return $append;
    }
}