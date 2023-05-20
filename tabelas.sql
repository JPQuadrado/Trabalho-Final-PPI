CREATE TABLE anunciante(
    codigo int PRIMARY KEY auto_increment,
    nome varchar(50),
    cpf char(14) UNIQUE,
    email varchar(50) UNIQUE,
    hash_senha varchar(255),
    telefone varchar(30)
) ENGINE=InnoDB;

CREATE TABLE categoria(
    codigo int PRIMARY KEY auto_increment,
    nome varchar(50),
    descricao varchar(255)
) ENGINE=InnoDB;

CREATE TABLE anuncio(
    codigo int PRIMARY KEY auto_increment,
    cod_categoria int not null,
    cod_anunciante int not null,
    titulo varchar(50),
    descricao varchar(10000),
    preco float,
    data_hora datetime,
    cep char(10),
    bairro varchar(50),
    cidade varchar(50),
    estado varchar(50),
    FOREIGN KEY (cod_categoria) REFERENCES categoria(codigo) ON DELETE CASCADE,
    FOREIGN KEY (cod_anunciante) REFERENCES anunciante(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE interesse(
    codigo int PRIMARY KEY auto_increment,
    mensagem varchar(255),
    data_hora datetime,
    contato varchar(50),
    cod_anuncio int not null,
    FOREIGN KEY (cod_anuncio) REFERENCES anuncio(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE foto(
    cod_anuncio int not null,
    nome_arquivo_foto varchar(255),
    FOREIGN KEY (cod_anuncio) REFERENCES anuncio(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE base_endereco_ajax(
    cep char(10),
    bairro varchar(50),
    cidade varchar(50),
    estado varchar(50)
) ENGINE=InnoDB;anuncianteanunciante

INSERT INTO categoria VALUES (default, "Veículo", "A categoria de veículo é uma classificação ampla que engloba diversos tipos de meios de transporte motorizados. Esses veículos podem ser utilizados para transportar pessoas, bens, mercadorias, materiais e equipamentos de um lugar para outro.");
INSERT INTO categoria VALUES (default, "Eletroeletrônico", "A categoria de eletroeletrônicos engloba uma ampla gama de dispositivos eletrônicos que são alimentados por energia elétrica. Esses dispositivos incluem desde aparelhos domésticos, como televisores, geladeiras e aspiradores de pó.");
INSERT INTO categoria VALUES (default, "Imóvel", "A categoria de imóvel engloba uma ampla variedade de propriedades, incluindo residenciais, comerciais, industriais e terrenos.");
INSERT INTO categoria VALUES (default, "Vestuário", "A categoria de vestuário engloba todas as peças de roupa, calçados e acessórios que são usados para cobrir e proteger o corpo.");
INSERT INTO categoria VALUES (default, "Outros", "A categoria 'outros' é uma classificação ampla que engloba uma ampla variedade de itens que não se enquadram em outras categorias mais específicas.");

INSERT INTO anunciante (nome, cpf, email, hash_senha, telefone)
VALUES ('Anunciante 1', '123.456.789-01', 'anunciante1@email.com', 'hash123', '1234567890'),
       ('Anunciante 2', '987.654.321-01', 'anunciante2@email.com', 'hash456', '0987654321'),
       ('Anunciante 3', '111.222.333-01', 'anunciante3@email.com', 'hash789', '1112223330');
       
INSERT INTO anuncio (cod_categoria, cod_anunciante, titulo, descricao, preco, data_hora, cep, bairro, cidade, estado)
VALUES (1, 1, 'Anúncio 1', 'Descrição do Anúncio 1', 100.00, NOW(), '12345-678', 'Bairro 1', 'Cidade 1', 'Estado 1'),
       (2, 1, 'Anúncio 2', 'Descrição do Anúncio 2', 200.00, NOW(), '23456-789', 'Bairro 2', 'Cidade 2', 'Estado 2'),
       (3, 1, 'Anúncio 3', 'Descrição do Anúncio 3', 300.00, NOW(), '34567-890', 'Bairro 3', 'Cidade 3', 'Estado 3');