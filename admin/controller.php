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

/**
 * Controller principal do componente ExpenseManager.
 */
class ExpenseManagerController extends JControllerLegacy
{
    /**
     * A view padrão a ser exibida quando nenhuma é especificada.
     *
     * @var    string
     */
    protected $default_view = 'expenses';
}