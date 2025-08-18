<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.1.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formrule');


class ExpenseManagerRuleDatefilter extends JFormRule
{
    protected $regex = '/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/';

    /**

     * @param   SimpleXMLElement  $element O elemento XML do campo.
     * @param   mixed             $value   O valor a ser testado.
     * @param   string            $group   O grupo do campo (opcional).
     * @param   JRegistry         $input   Todos os dados do formulário.
     * @param   JForm             $form    O objeto do formulário.
     *
     * @return  boolean  True se o valor for válido, False caso contrário.
     */
    public function test(\SimpleXMLElement $element, $value, $group = null, \JRegistry $input = null, \JForm $form = null)
    {
        $required = ((string) $element['required'] === 'true' || (string) $element['required'] === 'required');
        if (!$required && empty($value)) {
            return true;
        }

        return (bool) preg_match($this->regex, $value);
    }
}