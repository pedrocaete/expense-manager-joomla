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

class ExpenseManagerModelClients extends JModelList
{
/**
     * Construtor do model
     * * @param array $config Configuration array
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'name', 'a.name',
                'client_type', 'a.client_type',
                'cnpj', 'a.cnpj',
                'city_id', 'a.city_id',
                'contact_person', 'a.contact_person',
                'contact_email', 'a.contact_email',
                'published', 'a.published',
                'ordering', 'a.ordering'
            );
        }

        parent::__construct($config);
    }

    /**
     * Constrói a query SQL para buscar os dados
     * 
     * Este método é chamado automaticamente pelo JModelList
     * Aqui definimos:
     * - Quais tabelas consultar
     * - Quais campos selecionar  
     * - Como fazer JOIN entre tabelas
     * 
     * @return JDatabaseQuery
     */
    protected function getListQuery()
    {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.name, a.client_type, a.cnpj, a.city_id, a.contact_person, a.contact_email, a.published, a.created, a.created_by, a.ordering'
            )
        );

        $query->from('#__expensemanager_clients AS a');

        $query->select('c.name AS city_name');
        $query->join('LEFT', '#__expensemanager_cities AS c ON c.id = a.city_id');

        $query->select('u.name AS created_by_name')
              ->join('LEFT', '#__users AS u ON u.id = a.created_by');


        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('a.published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(a.published = 0 OR a.published = 1)');
        }

        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                $query->where('a.id = ' . (int) substr($search, 3));
            }
            else
            {
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where(
                    '(a.name LIKE ' . $search .
                    ' OR a.cnpj LIKE ' . $search .
                    ' OR a.contact_person LIKE ' . $search .
                    ' OR a.contact_email LIKE ' . $search . ')'
                );
            }
        }

        $orderCol = $this->state->get('list.ordering', 'a.name');
        $orderDirn = $this->state->get('list.direction', 'ASC');
        
        $orderCol = $db->escape($orderCol);
        $orderDirn = $db->escape($orderDirn);
        
        $query->order($orderCol . ' ' . $orderDirn);

        return $query;
    }

    /**
     * Define os estados (filtros) padrão do model
     */
    protected function populateState($ordering = 'name', $direction = 'asc')
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        parent::populateState($ordering, $direction);
    }

    /**
     * Obtém uma instância da JTable correspondente
     * 
     * @param string $type Table type
     * @param string $prefix Table prefix  
     * @param array $config Configuration array
     * @return JTable
     */
    public function getTable($type = 'Client', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Retorna uma instância do formulário de filtro.
     *
     * @param   array    $data      Dados para o formulário.
     * @param   boolean  $loadData  True para carregar os dados do filtro da sessão.
     *
     * @return  JForm|false  Um objeto JForm ou false em caso de erro.
     */
    public function getFilterForm($data = [], $loadData = true)
    {
        return $this->loadForm(
            $this->context . '.filter',
            'filter_clients',
            array('control' => 'filter', 'load_data' => $loadData)
        );
    }
}