-- Tabela de cidades
CREATE TABLE IF NOT EXISTS `#__expensemanager_cities` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `state` VARCHAR(100) NOT NULL DEFAULT '',
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    `ordering` INT(11) NOT NULL DEFAULT 0,
    `checked_out` INT(11) NOT NULL DEFAULT 0,
    `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Tabela de consultores
CREATE TABLE IF NOT EXISTS `#__expensemanager_consultants` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `email` VARCHAR(255) NOT NULL DEFAULT '',
    `phone` VARCHAR(50) NOT NULL DEFAULT '',
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    `ordering` INT(11) NOT NULL DEFAULT 0,
    `checked_out` INT(11) NOT NULL DEFAULT 0,
    `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Tabela de clientes (municípios/órgãos públicos)
CREATE TABLE IF NOT EXISTS `#__expensemanager_clients` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `client_type` VARCHAR(100) NOT NULL DEFAULT 'municipality',
    `cnpj` VARCHAR(18) NOT NULL DEFAULT '',
    `city_id` INT(11) NOT NULL DEFAULT 0,
    `contact_person` VARCHAR(255) NOT NULL DEFAULT '',
    `contact_email` VARCHAR(255) NOT NULL DEFAULT '',
    `contact_phone` VARCHAR(50) NOT NULL DEFAULT '',
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    `ordering` INT(11) NOT NULL DEFAULT 0,
    `checked_out` INT(11) NOT NULL DEFAULT 0,
    `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_city` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Tabela de categorias de gastos
CREATE TABLE IF NOT EXISTS `#__expensemanager_categories` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    `ordering` INT(11) NOT NULL DEFAULT 0,
    `checked_out` INT(11) NOT NULL DEFAULT 0,
    `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Tabela de relacionamento N:N entre consultores e clientes
CREATE TABLE IF NOT EXISTS `#__expensemanager_consultant_clients` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `consultant_id` INT(11) NOT NULL,
    `client_id` INT(11) NOT NULL,
    `link_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_consultant_client` (`consultant_id`, `client_id`),
    KEY `idx_consultant` (`consultant_id`),
    KEY `idx_client` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Tabela principal de gastos
CREATE TABLE IF NOT EXISTS `#__expensemanager_expenses` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `consultant_id` INT(11) NOT NULL,
    `client_id` INT(11) NOT NULL,
    `category_id` INT(11) NOT NULL,
    `description` TEXT NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `expense_date` DATE NOT NULL,
    `invoice_number` VARCHAR(100) NOT NULL DEFAULT '',
    `notes` TEXT,
    `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` INT(11) NOT NULL DEFAULT 0,
    `modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` INT(11) NOT NULL DEFAULT 0,
    `published` TINYINT(1) NOT NULL DEFAULT 1,
    `ordering` INT(11) NOT NULL DEFAULT 0,
    `checked_out` INT(11) NOT NULL DEFAULT 0,
    `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`),
    KEY `idx_consultant_client` (`consultant_id`, `client_id`),
    KEY `idx_consultant` (`consultant_id`),
    KEY `idx_client` (`client_id`),
    KEY `idx_category` (`category_id`),
    KEY `idx_expense_date` (`expense_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

-- Inserir dados padrão para as categorias
INSERT INTO `#__expensemanager_categories` (`name`, `description`, `created`, `published`, `ordering`) VALUES
('Hospedagem', 'Gastos com hotéis, pousadas e acomodações', NOW(), 1, 1),
('Alimentação', 'Gastos com refeições e lanches', NOW(), 1, 2),
('Transporte', 'Gastos com passagens, combustível e transporte', NOW(), 1, 3),
('Material de Escritório', 'Gastos com papelaria e materiais de trabalho', NOW(), 1, 4),
('Comunicação', 'Gastos com telefone, internet e correios', NOW(), 1, 5),
('Outros', 'Outros gastos não categorizados', NOW(), 1, 6);