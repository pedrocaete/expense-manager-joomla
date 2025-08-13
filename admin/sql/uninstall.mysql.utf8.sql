-- Remove as tabelas na ordem correta (devido às foreign keys)
-- Primeiro remove tabelas que referenciam outras

DROP TABLE IF EXISTS `#__expensemanager_expenses`;
DROP TABLE IF EXISTS `#__expensemanager_consultant_clients`;
DROP TABLE IF EXISTS `#__expensemanager_clients`;
DROP TABLE IF EXISTS `#__expensemanager_categories`;
DROP TABLE IF EXISTS `#__expensemanager_consultants`;
DROP TABLE IF EXISTS `#__expensemanager_cities`;