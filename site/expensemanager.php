<?php
/**
 * @package     ExpenseManager
 * @subpackage  Site
 * @version     1.0.0
 * @author      Pedro Inácio Rodrigues Pontes
 * @copyright   Copyright (C) 2025. Todos os direitos reservados.
 * @license     GNU General Public License version 2
 */

defined('_JEXEC') or die('Restricted access');

JForm::addFormPath(JPATH_COMPONENT_SITE . '/models/forms');
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('ExpenseManager');

$controller->execute(JFactory::getApplication()->input->get('task'));

$controller->redirect();