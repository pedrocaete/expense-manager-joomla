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
 * Controller para Lista de Consultores
 * 
 * Este controller gerencia as ações em massa na lista:
 * - Publicar/Despublicar múltiplos consultores
 * - Deletar múltiplos consultores
 * - Reordenar consultores
 */
class ExpenseManagerControllerConsultants extends JControllerAdmin
{
    /**
     * Define qual model usar para operações em massa
     * O Joomla automaticamente procura por ExpenseManagerModelConsultant
     */
    protected $text_prefix = 'COM_EXPENSEMANAGER_CONSULTANTS';

    /**
     * Obtém o model para um item individual
     * Usado nas operações de publish, unpublish, delete, etc.
     */
    public function getModel($name = 'Consultant', $prefix = 'ExpenseManagerModel', $config = array())
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }
}