<?php
defined('_JEXEC') or die('Restricted access');

class ExpenseManagerModelTechnicalvisit extends JModelForm
{
    protected $text_prefix = 'COM_EXPENSEMANAGER_TECHNICALVISIT';

    public function getTable($type = 'Technicalvisit', $prefix = 'ExpenseManagerTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm(
            'com_expensemanager.technicalvisit',
            'technicalvisit',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = JFactory::getApplication()->getUserState('com_expensemanager.edit.technicalvisit.data', array());

        if (empty($data)) {
            $item = $this->getItem();

            if (empty($item->id)) {
                $user = JFactory::getUser();
                $item->consultant_id = array($user->id);
            }

            $data = (array) $item;
        }

        return $data;
    }

    public function save($data)
    {
        $db = $this->getDbo();
        
        // Salva a tabela principal
        $table = $this->getTable();
        if (!$table->bind($data) || !$table->store()) {
            $this->setError($table->getError());
            return false;
        }

        $visitId = (int) $table->id;
        $consultantIds = isset($data['consultant_id']) ? (array) $data['consultant_id'] : array();

        // Inicia uma transação para garantir a integridade dos dados
        $db->transactionStart();

        try {
            // 1. Deleta os registos antigos da tabela de relação
            $deleteQuery = $db->getQuery(true)
                ->delete($db->quoteName('#__expensemanager_technical_visit_consultants'))
                ->where($db->quoteName('technical_visit_id') . ' = ' . $visitId);
            $db->setQuery($deleteQuery)->execute();

            // 2. Insere cada novo registo individualmente (a abordagem mais robusta)
            if (!empty($consultantIds)) {
                foreach ($consultantIds as $consultantId) {
                    if ((int)$consultantId > 0) {
                        $insertQuery = $db->getQuery(true)
                            ->insert($db->quoteName('#__expensemanager_technical_visit_consultants'))
                            ->columns(array($db->quoteName('technical_visit_id'), $db->quoteName('consultant_id')))
                            ->values($visitId . ', ' . (int)$consultantId);
                        $db->setQuery($insertQuery)->execute();
                    }
                }
            }
            
            // 3. Se tudo correu bem, confirma as alterações no banco de dados
            $db->transactionCommit();

        } catch (Exception $e) {
            // 4. Se algo falhar, reverte todas as alterações e reporta o erro
            $db->transactionRollback();
            $this->setError('Erro crítico no banco de dados ao salvar consultores: ' . $e->getMessage());
            return false;
        }

        // Define o ID no estado do model para o controller usar no redirecionamento
        $this->setState($this->context . '.id', $visitId);
        
        return true;
    }

    public function getItem($pk = null)
    {
        $pk = (!empty($pk)) ? $pk : (int) JFactory::getApplication()->input->getInt('id');

        if ($pk > 0) {
            try {
                $db    = $this->getDbo();
                $query = $db->getQuery(true);

                $query->select('tv.*, c.name AS client_name')
                    ->from($db->quoteName('#__expensemanager_technical_visits', 'tv'))
                    ->join('LEFT', $db->quoteName('#__expensemanager_clients', 'c') . ' ON c.id = tv.client_id')
                    ->where('tv.id = ' . (int) $pk);

                $db->setQuery($query);
                $item = $db->loadObject();

                if ($item) {
                    $query->clear()
                        ->select($db->quoteName('consultant_id'))
                        ->from($db->quoteName('#__expensemanager_technical_visit_consultants'))
                        ->where($db->quoteName('technical_visit_id') . ' = ' . (int) $pk);
                    $db->setQuery($query);
                    $item->consultant_id = $db->loadColumn();
                }

                return $item;
            } catch (Exception $e) {
                $this->setError($e->getMessage());
                return false;
            }
        }

        return new stdClass();
    }
}
