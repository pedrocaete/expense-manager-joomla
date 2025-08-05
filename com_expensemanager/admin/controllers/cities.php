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
 * Controller para Lista de Cidades
 * 
 * Este controller gerencia as ações em massa na lista:
 * - Publicar/Despublicar múltiplas cidades
 * - Deletar múltiplas cidades
 * - Reordenar cidades
 */
class ExpenseManagerControllerCities extends JControllerAdmin
{
    /**
     * Define qual model usar para operações em massa
     * O Joomla automaticamente procura por ExpenseManagerModelCity
     */
    protected $text_prefix = 'COM_EXPENSEMANAGER_CITIES';

    /**
     * Obtém o model para um item individual
     * Usado nas operações de publish, unpublish, delete, etc.
     */
    public function getModel($name = 'City', $prefix = 'ExpenseManagerModel', $config = array())
    {
        $model = parent::getModel($name, $prefix, array('ignore_request' => true));
        return $model;
    }
}