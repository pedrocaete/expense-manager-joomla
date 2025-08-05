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
 * Classe JTable para Consultores
 * 
 * JTable é a camada de acesso aos dados no Joomla.
 * Ela cuida de:
 * - Salvar/carregar dados do banco
 * - Validar dados antes de salvar
 * - Gerenciar campos automáticos (created, modified, etc.)
 * - Sistema de checkout (lock de edição)
 */
class ExpenseManagerTableConsultant extends JTable
{
    /**
     * Construtor da tabela
     * 
     * @param JDatabaseDriver $db Database connector object
     */
    public function __construct($db)
    {
        // Define qual tabela do banco esta classe gerencia
        // Parâmetros: nome_da_tabela, campo_chave_primaria, database_object
        parent::__construct('#__expensemanager_consultants', 'id', $db);
        
        // Define campos que são atualizados automaticamente
        $this->_trackAssets = false; // Não usar sistema de assets do Joomla
    }

    /**
     * Validação dos dados antes de salvar
     * 
     * Este método é chamado automaticamente antes de store()
     * Aqui definimos as regras de validação dos campos
     * 
     * @return boolean True se válido, false se inválido
     */
    public function check()
    {
        // Limpa espaços em branco do nome
        $this->name = trim($this->name);
        $this->email = trim($this->email);
        $this->phone = trim($this->phone);

        // Validação: nome é obrigatório
        if (empty($this->name))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CONSULTANT_NAME_REQUIRED'));
            return false;
        }

        if (empty($this->email))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CONSULTANT_EMAIL_REQUIRED'));
            return false;
        }

        if (!JMailHelper::isEmailAddress($this->email))
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CONSULTANT_EMAIL_INVALID'));
            return false;
        }

        // Se chegou até aqui, está tudo válido
        return true;
    }

    /**
     * Método executado antes de salvar
     * 
     * Aqui definimos valores automáticos para campos como created, modified, etc.
     * 
     * @param boolean $updateNulls True para atualizar campos null
     * @return boolean True em caso de sucesso
     */
    public function store($updateNulls = true)
    {
        $date = JFactory::getDate();
        $user = JFactory::getUser();

        // Se é um novo registro (não tem ID)
        if (empty($this->id))
        {
            // Define dados de criação
            $this->created = $date->toSql();
            $this->created_by = $user->get('id');
        }

        // Sempre atualiza dados de modificação
        $this->modified = $date->toSql();
        $this->modified_by = $user->get('id');

        // Se não foi definido, marca como publicado
        if (!isset($this->published))
        {
            $this->published = 1;
        }

        // Chama o método store da classe pai
        return parent::store($updateNulls);
    }

    /**
     * Método executado antes de deletar
     * 
     * Aqui verificamos se é seguro deletar o registro
     * 
     * @param mixed $pk Primary key value
     * @return boolean True se pode deletar
     */
    public function delete($pk = null)
    {
        // Define a chave primária se não foi passada
        $k = $this->_tbl_key;
        $pk = (is_null($pk)) ? $this->$k : $pk;

        // Verifica se há clientes usando esta cidade
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from('#__expensemanager_expenses')
            ->where('consultant_id = ' . (int) $pk);
        $db->setQuery($query);
        $count = $db->loadResult();

        // Se há clientes usando, não permite deletar
        if ($count > 0)
        {
            $this->setError(JText::_('COM_EXPENSEMANAGER_ERROR_CONSULTANT_HAS_CLIENTS'));
            return false;
        }

        // Se chegou até aqui, pode deletar
        return parent::delete($pk);
    }
}