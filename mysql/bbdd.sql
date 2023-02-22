CREATE DATABASE proyectopeliculas;

USE proyectopeliculas;

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE IF NOT EXISTS `usuarios`( 
`id`             int auto_increment not null,
`nombre`          varchar(100) COLLATE utf8mb4_unicode_ci not null,
`apellidos`       varchar(255) COLLATE utf8mb4_unicode_ci,
`email`           varchar(255) COLLATE utf8mb4_unicode_ci not null,
`password`        varchar(255) COLLATE utf8mb4_unicode_ci not null,
`rol`             varchar(20) COLLATE utf8mb4_unicode_ci,
CONSTRAINT pk_usuarios PRIMARY KEY(`id`),
CONSTRAINT uq_email UNIQUE(`email`)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `categorias`;

CREATE TABLE IF NOT EXISTS `categorias`(
`id`              int auto_increment not null,
`nombre`          varchar(100) COLLATE utf8mb4_unicode_ci not null,
CONSTRAINT pk_categorias PRIMARY KEY(`id`) 
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `peliculas`;
CREATE TABLE IF NOT EXISTS `peliculas`(
`id`              int auto_increment not null,
`categoria_id`    int(255) COLLATE utf8mb4_unicode_ci not null,
`usuario_id`      int(255) COLLATE utf8mb4_unicode_ci not null,
`titulo`          varchar(100) COLLATE utf8mb4_unicode_ci not null,
`sinopsis`        text COLLATE utf8mb4_unicode_ci,
`director`        varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci not null,
`precio`          float(100,2) COLLATE utf8mb4_unicode_ci not null,
`stock`           int(255) COLLATE utf8mb4_unicode_ci not null,
`imagen`          varchar(255),
CONSTRAINT pk_categorias PRIMARY KEY(`id`),
CONSTRAINT fk_pelicula_categoria FOREIGN KEY(`categoria_id`) REFERENCES categorias(`id`),
CONSTRAINT fk_pelicula_usuario FOREIGN KEY(`usuario_id`) REFERENCES usuarios(`id`)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos`(
`id`              int auto_increment not null,
`usuario_id`      int(255) not null,
`provincia`       varchar(100) not null,
`localidad`       varchar(100) not null,
`direccion`       varchar(255) not null,
`coste`           float(200,2) not null,
`estado`          varchar(20) not null,
`fecha`           date,
`hora`            time,
CONSTRAINT pk_pedidos PRIMARY KEY(`id`),
CONSTRAINT fk_pedido_usuario FOREIGN KEY(`usuario_id`) REFERENCES usuarios(`id`)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `lineas_pedidos`;
CREATE TABLE IF NOT EXISTS `lineas_pedidos`(
`id`              int(255) auto_increment not null,
`pedido_id`       int(255) not null,
`pelicula_id`     int(255) not null,
`unidades`        int(255) not null,
CONSTRAINT pk_lineas_pedidos PRIMARY KEY(`id`),
CONSTRAINT fk_linea_pedido FOREIGN KEY(`pedido_id`) REFERENCES pedidos(`id`),
CONSTRAINT fk_linea_pelicula FOREIGN KEY(`pelicula_id`) REFERENCES peliculas(`id`)
)ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO usuarios(id, nombre, apellidos, email, password, rol) VALUES ( 1, 'Lola', 'Gomez', 'lola@gmail.com', '$2y$04$S7bpxuE53VpF8reI7RelieKpDEmLqXG3y6Und05DkfRKirYnYJ2dS', 'admin');
INSERT INTO usuarios(id, nombre, apellidos, email, password, rol) VALUES ( 2, 'Pedro', 'Garcia', 'pedro@gmail.com', '$2y$04$mHetWjMkhz4OZ1DsGJnW9OEpoYfazP.ql8uffWhO/rQM6fJvVExY.', 'user');

INSERT INTO categorias(id, nombre) VALUES (1, 'Aventura');
INSERT INTO categorias(id, nombre) VALUES (2, 'Terror');


INSERT INTO peliculas(id, categoria_id, usuario_id, titulo, sinopsis, director, precio, stock, imagen) 
        VALUES (1, 1, 1, 'El señor de los anillos', 'En la Tierra Media, el Señor Oscuro Sauron forjó los Grandes Anillos del Poder y creó uno con el poder de esclavizar a toda la Tierra Media. Frodo Bolsón es un hobbit al que su tío Bilbo hace portador del poderoso Anillo Único con la misión de destruirlo. Acompañado de sus amigos, Frodo emprende un viaje hacia Mordor, el único lugar donde el anillo puede ser destruido. Sin embargo, Sauron ordena la persecución del grupo para recuperar el anillo y acabar con la Tierra Media.', 'Peter Jackson', 10.00, 50, 'anillos.jpg');


INSERT INTO peliculas(id, categoria_id, usuario_id, titulo, sinopsis, director, precio, stock, imagen) 
        VALUES (2, 2, 1, 'Pesadilla en Elm Street', 'Varios jóvenes de una pequeña localidad tienen habitualmente pesadillas en las que son perseguidos por un hombre deformado por el fuego y que usa un guante terminado en afiladas cuchillas. Algunos de ellos comienzan a ser asesinados mientras duermen por este ser, que resulta ser un asesino al que los padres de estos jóvenes quemaron vivo hace varios años tras descubrir que había asesinado a varios niños.', 'Wes Craven', 5.00, 10, 'terror.png');


