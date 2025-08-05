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
 * View para Lista de Cidades
 * 
 * Esta classe prepara dados do Model para exibição no template.
 * Responsável por:
 * - Carregar dados do model
 * - Preparar toolbar (botões Novo, Editar, Deletar)
 * - Definir título da página
 * - Preparar filtros e ordenação
 */
class ExpenseManagerViewCities extends JViewLegacy
{
    /**
     * Dados que serão passados para o template
     */
    public $items;
    public $pagination;
    public $state;
    public $filterForm;
    public $activeFilters;

    /**
     * Método principal - prepara e exibe a view
     */
    public function display($tpl = null)
    {
        // Obtém dados do model
        $this->items         = $this->get('Items');
        $this->pagination    = $this->get('Pagination');
        $this->state         = $this->get('State');
        $this->filterForm    = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

        // Verifica se houve erros
        if (count($errors = $this->get('Errors')))
        {
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }

        // Adiciona arquivos CSS/JS necessários
        $this->addToolbar();

        ExpenseManagerHelper::addSubmenu('cities'); 

        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    /**
     * Adiciona toolbar (barra de botões)
     */
    protected function addToolbar()
    {
        $canDo = ExpenseManagerHelper::getActions();
        $user  = JFactory::getUser();

        // Título da página
        JToolbarHelper::title(JText::_('COM_EXPENSEMANAGER_CITIES_MANAGER'), 'location');

        // Botão "Novo" - criar nova cidade
        if ($canDo->get('core.create'))
        {
            JToolbarHelper::addNew('city.add');
        }

        // Se há itens selecionados, mostra botões de ação
        if (!empty($this->items))
        {
            // Botão "Editar"
            if ($canDo->get('core.edit'))
            {
                JToolbarHelper::editList('city.edit');
            }

            // Botão "Publicar"
            if ($canDo->get('core.edit.state'))
            {
                JToolbarHelper::publish('cities.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish('cities.unpublish', 'JTOOLBAR_UNPUBLISH', true);
            }

            // Botão "Deletar"
            if ($canDo->get('core.delete'))
            {
                JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'cities.delete', 'JTOOLBAR_DELETE');
            }
        }

        // Botão "Opções" (configurações)
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_expensemanager');
        }

        // Adiciona filtros na sidebar
        JHtmlSidebar::setAction('index.php?option=com_expensemanager&view=cities');
    }

        /**
     * Retorna os campos de ordenação para o layout de searchtools.
     * Este método é chamado pelo tmpl/default.php.
     *
     * @return  array  Um array de campos pelos quais a lista pode ser ordenada.
     */
    protected function getSortFields()
    {
        return array(
            'a.ordering'  => JText::_('JGRID_HEADING_ORDERING'),
            'a.published' => JText::_('JSTATUS'),
            'a.name'      => JText::_('COM_EXPENSEMANAGER_CITY_NAME'),
            'a.state'     => JText::_('COM_EXPENSEMANAGER_CITY_STATE'),
            'a.created_by'=> JText::_('JGRID_HEADING_CREATED_BY'),
            'a.created'   => JText::_('JDATE'),
            'a.id'        => JText::_('JGRID_HEADING_ID')
        );
    }
}