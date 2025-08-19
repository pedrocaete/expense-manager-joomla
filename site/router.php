<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.3
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die;

function ExpenseManagerBuildRoute(&$query)
{
    $segments = array();

    if (isset($query['view']))
    {
        $segments[] = $query['view'];
        unset($query['view']);
    }

    if (isset($query['id']))
    {
        $segments[] = (int) $query['id'];
        unset($query['id']);
    }

    return $segments;
}

function ExpenseManagerParseRoute($segments)
{
    $vars = array();

    $count = count($segments);

    if ($count > 0)
    {
        $vars['view'] = $segments[0];

        if ($count > 1)
        {
            $vars['id'] = (int) $segments[1];
        }
    }

    return $vars;
}