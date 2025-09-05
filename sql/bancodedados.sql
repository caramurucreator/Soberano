-- Criar usuário e conceder privilégios
CREATE USER IF NOT EXISTS 'soberano'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON soberano.* TO 'soberano'@'localhost';
FLUSH PRIVILEGES;

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS soberano;
USE soberano;

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE if not exists clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);


-- Criar tabela produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    categoria ENUM('botinas','chapeus','cintos','calcas') NOT NULL,
    sexo ENUM('masculino','feminino','unissex') DEFAULT 'unissex',
    imagem VARCHAR(100),
    estoque INT DEFAULT 10
);

-- ==============================
-- BOTINAS FEMININAS
-- ==============================
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Bota Texana Feminina', 'Couro Flores Bordadas Corridas', 1796.00, 'botinas', 'feminino', 'botina_f1.webpclientesclientes'),
('Bota Texana Country Feminina', 'Couro Legítimo Solado Borracha', 1777.80, 'botinas', 'feminino', 'botina_f2.webp'),
('Bota Texana Bordada Feminina', 'Laser Com Gliter Sola Jump', 3794.00, 'botinas', 'feminino', 'botina_f3.webp'),
('Botina Country Texana Feminina', 'Couro Rodeios Festa', 1596.90, 'botinas', 'feminino', 'botina_f4.webp'),
('Botina Texana Bordada Feminina', 'Exposições De Animais Corridas', 1796.00, 'botinas', 'feminino', 'botina_f5.webp');

-- BOTINAS MASCULINAS
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Bota Country Masculina Texana', 'Em Couro Franca', 1732.00, 'botinas', 'masculino', 'botina_m1.webp'),
('Bota Texana Masculina', 'Couro Cano Azul Rodeio Cavalgada Cavalo', 1857.80, 'botinas', 'masculino', 'botina_m2.webp'),
('Bota Texana Masculina', 'Couro Legítimo Bico Redondo Top', 1796.00, 'botinas', 'masculino', 'botina_m3.webp'),
('Botina Texana Masculina', 'Bico Quadrada Cano Curto 100% Couro', 1596.00, 'botinas', 'masculino', 'botina_m4.webp'),
('Botina Texana Masculina', 'Couro Froter Sola Café Comitivas', 1596.90, 'botinas', 'masculino', 'botina_m5.webp');

-- ==============================
-- CHAPÉUS
-- ==============================
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Chapéu Pralana', 'Bangora Rodeo Cross Aba 12', 453.86, 'chapeus', 'unissex', 'chapeu1.webp'),
('Chapéu Eldorado', '15X Forth Worth C. Ropers EC1510', 629.91, 'chapeus', 'unissex', 'chapeu2.webp'),
('Chapéu Ariat', 'Feltro 6x Black A7630201', 2276.91, 'chapeus', 'unissex', 'chapeu3.webp'),
('Chapéu Pralana Arizona', 'VI Azul Pastelo', 456.58, 'chapeus', 'unissex', 'chapeu4.webp'),
('Chapéu Pralana Journey', 'Felt III Preto', 575.88, 'chapeus', 'unissex', 'chapeu5.webp'),
('Chapéu Pralana Shantung', '30x Trança', 1199.43, 'chapeus', 'unissex', 'chapeu6.webp'),
('Chapéu Pralana Champion', 'Strass Forest', 564.72, 'chapeus', 'unissex', 'chapeu8.webp'),
('Chapéu Eldorado', '20X Ultimate EC798', 1079.01, 'chapeus', 'unissex', 'chapeu9.webp'),
('Chapéu Eldorado', 'Cristal Gold Camel EC1307.C', 539.01, 'chapeus', 'unissex', 'chapeu10.webp'),
('Chapéu Mexican Hats', 'Fast Rope MH3046', 989.01, 'chapeus', 'unissex', 'chapeu11.webp'),
('Chapéu Resistol Importado', '6x USTRC Chocolate', 2699.01, 'chapeus', 'unissex', 'chapeu12.webp'),
('Chapéu Charlie 1', 'Horse Importado 4x Teepee', 1439.01, 'chapeus', 'unissex', 'chapeu13.webp');

-- ==============================
-- CINTOS MASCULINOS
-- ==============================
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Cinto Ariat Masculino', 'Country de Couro', 103.80, 'cintos', 'masculino', 'cinto_m1.webp'),
('Cinto Country Vintage Masculino', 'Couro Legítimo', 130.45, 'cintos', 'masculino', 'cinto_m2.webp'),
('Cinto Country Masculino', 'Couro Jenny Buff', 99.90, 'cintos', 'masculino', 'cinto_m3.webp');

-- CINTOS FEMININOS
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Cinto Hard Feminino', 'Couro Legítimo Cravejado', 130.89, 'cintos', 'feminino', 'cinto_f1.webp'),
('Cinto Soft Feminino', 'Couro Simples Claro', 70.90, 'cintos', 'feminino', 'cinto_f2.webp'),
('Cinto Country Feminino', 'Preto Cravejado', 69.90, 'cintos', 'feminino', 'cinto_f3.webp');

-- ==============================
-- CALÇAS
-- ==============================
INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES
('Calça Country Feminina', 'Bordada Cruz', 305.10, 'calcas', 'feminino', 'calca1.webp'),
('Calça Jeans Feminina', 'Bordada Cavalo', 280.90, 'calcas', 'feminino', 'calca2.webp'),
('Calça Country', 'Preta Cravejada', 270.70, 'calcas', 'unissex', 'calca3.webp'),
('Calça Country Clara Feminina', 'Cravejada Light', 289.90, 'calcas', 'feminino', 'calca4.webp');

