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
 * Model para Lista de Consultores
 * 
 * Este é um "List Model" - usado para exibir listas de registros.
 * Herda de JModelList que já tem funcionalidades prontas para:
 * - Paginação
 * - Filtros
 * - Ordenação
 * - Busca
 */
class ExpenseManagerModelConsultants extends JModelList
{
    /**
     * Construtor do model
     * 
     * @param array $config Configuration array
     */
    public function __construct($config = array())
    {
        // Define quais campos podem ser usados para filtrar
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'name', 'a.name',
                'email', 'a.email',
                'phone', 'a.phone',
                'published', 'a.published',
                'created', 'a.created',
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
        // Obtém instância do banco de dados
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // SELECT: campos que queremos buscar
        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.name, a.email, a.phone, a.published, a.created, a.created_by, a.ordering'
            )
        );

        // FROM: tabela principal
        $query->from('#__expensemanager_consultants AS a');

        // JOIN: busca nome do usuário que criou
        $query->select('u.name AS created_by_name')
              ->join('LEFT', '#__users AS u ON u.id = a.created_by');

        // WHERE: filtros aplicados pelo usuário

        // Filtro por estado de publicação
        $published = $this->getState('filter.published');
        if (is_numeric($published))
        {
            $query->where('a.published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(a.published = 0 OR a.published = 1)');
        }

        // Filtro por busca de texto
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            if (stripos($search, 'id:') === 0)
            {
                // Busca por ID específico (ex: "id:123")
                $query->where('a.id = ' . (int) substr($search, 3));
            }
            else
            {
                // Busca por nome ou email
                $search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
                $query->where('(a.name LIKE ' . $search . ' OR a.email LIKE ' . $search . ' OR a.phone LIKE ' .$search . ')');
            }
        }

        // ORDER BY: ordenação dos resultados
        $orderCol = $this->state->get('list.ordering', 'a.name');
        $orderDirn = $this->state->get('list.direction', 'ASC');
        
        // Sanitiza os valores de ordenação
        $orderCol = $db->escape($orderCol);
        $orderDirn = $db->escape($orderDirn);
        
        $query->order($orderCol . ' ' . $orderDirn);

        return $query;
    }

    /**
     * Define os estados (filtros) padrão do model
     * 
     * Estados são variáveis que o model "lembra" entre requisições
     * Ex: qual filtro está ativo, quantos itens por página, etc.
     */
    protected function populateState($ordering = 'name', $direction = 'asc')
    {
        // Busca por texto
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        // Filtro por publicação
        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        // Chama método da classe pai para definir paginação e ordenação
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
    public function getTable($type = 'Consultant', $prefix = 'ExpenseManagerTable', $config = array())
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
            'filter_consultants',
            array('control' => 'filter', 'load_data' => $loadData)
        );
    }
}