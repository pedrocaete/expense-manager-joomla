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
 * Controller para Cidade Individual
 * 
 * Gerencia operações em uma cidade específica:
 * - Salvar
 * - Cancelar edição
 * - Aplicar (salvar e continuar editando)
 */
class ExpenseManagerControllerCity extends JControllerForm
{
    /**
     * Define o prefixo das mensagens de texto
     */
    protected $text_prefix = 'COM_EXPENSEMANAGER_CITY';

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