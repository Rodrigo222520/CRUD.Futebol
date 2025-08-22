CREATE DATABASE futebol_db;
USE futebol_db;

CREATE TABLE times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL
);

CREATE TABLE jogadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    posicao VARCHAR(30) NOT NULL,
    numero_camisa INT NOT NULL,
    time_id INT,
    FOREIGN KEY (time_id) REFERENCES times(id)
);

CREATE TABLE partidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    time_casa_id INT NOT NULL,
    time_fora_id INT NOT NULL,
    data_jogo DATE NOT NULL,
    gols_casa INT DEFAULT 0,
    gols_fora INT DEFAULT 0,
    FOREIGN KEY (time_casa_id) REFERENCES times(id),
    FOREIGN KEY (time_fora_id) REFERENCES times(id)
);

-- Times da Série A 2025
INSERT INTO times (nome, cidade) VALUES
('Atlético-MG','Belo Horizonte'),
('Flamengo','Rio de Janeiro'),
('Palmeiras','São Paulo'),
('Cruzeiro','Belo Horizonte'),
('Bahia','Salvador'),
('Botafogo','Rio de Janeiro'),
('Mirassol','Mirassol'),
('São Paulo','São Paulo'),
('Fluminense','Rio de Janeiro'),
('RB Bragantino','Bragança Paulista'),
('Ceará SC','Fortaleza'),
('Internacional','Porto Alegre'),
('Santos','Santos'),
('Vasco da Gama','Rio de Janeiro'),
('EC Vitória','Salvador'),
('Juventude','Caxias do Sul'),
('Fortaleza','Fortaleza'),
('Sport Recife','Recife'),
('Grêmio','Porto Alegre'),
('Corinthians','São Paulo');

-- Jogadores principais por time
INSERT INTO jogadores (nome, posicao, numero_camisa, time_id) VALUES
('Hulk','ATA',7,1),
('Everson','GOL',22,1),
('Pedro','ATA',9,2),
('Arrascaeta','MEI',14,2),
('Endrick','ATA',9,3),
('Weverton','GOL',21,3),
('Matheus Pereira','MEI',10,4),
('Rafinha','DEF',2,4),
('Cauly','MEI',8,5),
('Everton Ribeiro','MEI',10,5),
('Tiquinho Soares','ATA',9,6),
('Lucas Perri','GOL',12,6),
('Wellington Rato','MEI',10,8),
('Calleri','ATA',9,8),
('Germán Cano','ATA',14,9),
('Marcelo','DEF',12,9),
('Thiago Borbas','ATA',18,10),
('Cleiton','GOL',1,10),
('Alan Patrick','MEI',10,12),
('Maurício','MEI',27,12),
('Marcos Leonardo','ATA',9,13),
('Soteldo','MEI',10,13),
('Payet','MEI',10,14),
('Léo Jardim','GOL',1,14),
('Lucas Arcanjo','GOL',1,15),
('Osvaldo','ATA',11,15),
('Gilberto','ATA',9,16),
('Léo Chú','ATA',11,16),
('Moises','ATA',21,17),
('Yago Pikachu','MEI',22,17),
('Gustavo','ATA',9,18),
('Love','ATA',99,18),
('Diego Costa','ATA',19,19),
('Franco Cristaldo','MEI',10,19),
('Yuri Alberto','ATA',9,20),
('Cássio','GOL',12,20);

-- Partidas do Brasileirão 2025 (rodadas iniciais)
INSERT INTO partidas (time_casa_id, time_fora_id, data_jogo, gols_casa, gols_fora) VALUES
(2,14,'2025-04-14',2,1), -- Flamengo 2x1 Vasco
(3,8,'2025-04-21',1,0),  -- Palmeiras 1x0 São Paulo
(9,6,'2025-04-28',3,2),  -- Fluminense 3x2 Botafogo
(1,4,'2025-05-05',2,2),  -- Atlético-MG 2x2 Cruzeiro
(12,19,'2025-05-12',0,1), -- Internacional 0x1 Grêmio
(5,15,'2025-05-19',2,0), -- Bahia 2x0 Vitória
(10,20,'2025-05-26',1,1), -- Bragantino 1x1 Corinthians
(17,18,'2025-06-02',2,1), -- Fortaleza 2x1 Sport
(13,9,'2025-06-09',0,2),  -- Santos 0x2 Fluminense
(6,2,'2025-06-16',1,3);  -- Botafogo 1x3 Flamengo
