USE data_db;

-- query para los usuarios y perfiles

CREATE TABLE perfiles(

id 		  		int (255) auto_increment NOT NULL,
nombre 	   		varchar(150) NOT NULL,
descripcion 	text,
created_at  	datetime NOT NULL,
updated_at 		datetime NOT NULL,


CONSTRAINT pk_perfiles PRIMARY KEY (id)


)ENGINE=Innodb;


CREATE TABLE users(

id 		  		int (255) auto_increment NOT NULL,
nombres   		varchar(50) NOT NULL,
apellidos 		varchar(100),
contrasena		varchar(255) NOT NULL,
perfil_id 		int(255) NOT NULL,
email   		varchar(255) NOT NULL,
descripcion 	text,
image			varchar(255),
created_at  	datetime NOT NULL,
updated_at 		datetime NOT NULL,
remember_token 	varchar(255),

CONSTRAINT pk_users PRIMARY KEY (id),


CONSTRAINT fk_perfil FOREIGN KEY  (perfil_id) REFERENCES perfiles(id)

)ENGINE=Innodb;


-- sql de los modulos

CREATE TABLE tipo_identificacion(

id 		  		    int (255) auto_increment NOT NULL,
nombre              varchar(50) NOT NULL,
descripcion         text,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_tIdentificacion PRIMARY KEY (id)

)ENGINE=Innodb;

CREATE TABLE proveedores(

id 		  		    int (255) auto_increment NOT NULL,
nombre              varchar(50) NOT NULL,
tipo_iden_id        int (255)  NOT NULL,
num_identificacion  varchar(100) NOT NULL,
contacto1           varchar(20) NOT NULL,
contacto2           varchar(20),
email               varchar(255) NOT NULL,
direccion           varchar(100),
id_user          int (255)  NOT NULL,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_proveedores PRIMARY KEY (id),
CONSTRAINT fk_user  FOREIGN KEY (id_user ) REFERENCES users(id),
CONSTRAINT fk_Tindentificacion FOREIGN KEY  (tipo_iden_id) REFERENCES tipo_identificacion(id)

)ENGINE=Innodb;


CREATE TABLE categoria(

id              int (255) auto_increment NOT NULL,
nombre          varchar(50) NOT NULL,
descripcion     text,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_categoria PRIMARY KEY (id)

)ENGINE=Innodb;

CREATE TABLE medida(


id              int (255) auto_increment NOT NULL,
nombre          varchar(50) NOT NULL,
descripcion     text,
created_at		datetime DEFAULT NULL,
updated_at  	datetime DEFAULT NULL,

CONSTRAINT pk_medida PRIMARY KEY (id)

)ENGINE=Innodb;


CREATE TABLE materia(

id                  int (255) auto_increment NOT NULL,
nombre              varchar(200) NOT NULL,
cantidad            int (255) NOT NULL,
precio_compra       FLOAT NOT NULL,
categoria_id        int (255) NOT NULL,
medidad_id          int (255) NOT NULL,
proveedor_id        int (255) NOT NULL,
user             int (255) NOT NULL,
descripcion         text,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_matria PRIMARY KEY (id),

CONSTRAINT fk_categoria FOREIGN KEY  (categoria_id) REFERENCES categoria(id),
CONSTRAINT fk_medida    FOREIGN KEY  (medidad_id) REFERENCES medida(id),
CONSTRAINT fk_proveedor FOREIGN KEY  (proveedor_id) REFERENCES proveedores(id),
CONSTRAINT fk_user      FOREIGN KEY  (user) REFERENCES users(id)
)ENGINE=Innodb;





CREATE TABLE estado_op_venta(

    id                  int(255) auto_increment NOT NULL,
    nombre              varchar(255) NOT NULL,
    descripcion         text,
    created_at		    datetime DEFAULT NULL,
    updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_estado_op_venta PRIMARY KEY (id)

)ENGINE=Innodb;




CREATE TABLE estado_tarea(

    id                  int(255) auto_increment NOT NULL,
    nombre              varchar(255) NOT NULL,
    descripcion         text,
    created_at		    datetime DEFAULT NULL,
    updated_at  	    datetime DEFAULT NULL,

    CONSTRAINT pk_estado_tarea PRIMARY KEY (id)


)ENGINE=Innodb;




-- cotizaciones

CREATE TABLE estado_cotizacion(

  id        int (255) AUTO_INCREMENT NOT NULL,
  nombre        varchar (255) NOT NULL,
  descripcion   text,
  created_at      datetime DEFAULT NULL,
  updated_at       datetime DEFAULT NULL,

  CONSTRAINT pk_estado_cotizacion PRIMARY KEY (id)

)ENGINE=INNODB;


CREATE TABLE cotizaciones(

    id 				      	      int(255) AUTO_INCREMENT NOT NULL,
    id_cliente		    	      int(255) NOT NULL,
    id_user			    	      int(255) NOT NULL,
    id_op_venta 		          int(255),
    id_inmueble              int(255),


    cuota_congelacion         double(20,3) NOT NULL,
    pFecha_congelacion        datetime,
    porcentaje_cuota_inicial  int(50),
    valor_separacion 	      double(20,3) NOT NULL,
    cuota_inicial		      double(20,3) NOT NULL,
    descuento                 double(20,3) NOT NULL,
    fecha_cuota_inicial       date,

    num_cuotas			      int(50) NOT NULL,
    valor_cuota               int(50) NOT NULL,
    valor_credito		      double(20,3) NOT NULL,
    created_at                datetime DEFAULT NULL,
    updated_at                datetime DEFAULT NULL,

    CONSTRAINT	pk_cotizacion PRIMARY KEY (id),
    CONSTRAINT	fk_cliente_id FOREIGN KEY (id_cliente) REFERENCES clientes(id),
    CONSTRAINT  fk_user_id  FOREIGN KEY (id_user) REFERENCES users(id),
    CONSTRAINT fk_in_inmueble FOREIGN KEY (id_inmueble) REFERENCES  inmueble(id),
    CONSTRAINT	fk_id_op_venta FOREIGN KEY (id_op_venta) REFERENCES oportunidad_venta(id)


  )ENGINE=INNODB;



CREATE TABLE fecha_pagos_cotizaciones(

  id                int(255)  AUTO_INCREMENT NOT NULL,
  id_cotizacion     int(255) NOT NULL,
  fecha_pagos       datetime NOT NULL,¨
  valor_pago        int(255) NOT NULL,

  id_user		    int(255) NOT NULL,
  created_at       datetime DEFAULT NULL,
  updated_at       datetime DEFAULT NULL,

  CONSTRAINT pk_fecha_pagos  PRIMARY KEY (id),
  CONSTRAINT fk_cotizaciones FOREIGN KEY (id_cotizacion) REFERENCES cotizaciones(id),

  CONSTRAINT id_user_fk FOREIGN KEY (id_user) REFERENCES users(id)

)ENGINE=INNODB;





-- Bases de datos actualizadas


CREATE TABLE nivel_estudios(

  id                  int(255)  AUTO_INCREMENT NOT NULL,
  descripcion         text,
  created_at    datetime DEFAULT NULL,
  updated_at    datetime DEFAULT NULL,

  CONSTRAINT pk_nivel_estudios   PRIMARY KEY (id)


)ENGINE=INNODB;

CREATE TABLE clientes(

id                  int(255) auto_increment NOT NULL,
nombre              varchar(255) NOT NULL,
tipo_iden           int(255) NOT NULL,
num_identificacion  varchar(255) NOT NULL,
fecha_nacimiento    datetime DEFAULT NULL,
id_n_estudio   int(255) NOT NULL,
profesion           varchar(255) NOT NULL,
contacto1           varchar(50) NOT NULL,
contacto2           varchar(50) NOT NULL ,
email               varchar(255) NOT NULL,
descripcion         text,
id_user             int(255) NOT NULL,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_cliente PRIMARY KEY (id),

CONSTRAINT fk_tipo FOREIGN KEY  (tipo_iden) REFERENCES tipo_identificacion(id),
CONSTRAINT create_fk FOREIGN KEY  (id_user ) REFERENCES users(id),
CONSTRAINT fk_nivel_estudios FOREIGN KEY (id_n_estudio) REFERENCES  nivel_estudios(id)


)ENGINE=Innodb;


CREATE TABLE oportunidad_venta(

id                  int(255) auto_increment NOT NULL,
cliente_id          int(255) NOT NULL,

inmueble_id             int(255) NOT NULL,
id_user             int(255) NOT NULL,
cantidad            int(255) NOT NULL,
valor_compra        double(20,3) NOT NULL,
fecha_cierre        datetime NOT NULL,
estado_id           int(255) NOT NULL,
descripcion         text,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,

CONSTRAINT pk_oportunidad_venta PRIMARY KEY (id),


CONSTRAINT user_create_fk    FOREIGN KEY  (id_user)     REFERENCES users(id),
CONSTRAINT fk_cliente   FOREIGN KEY  (cliente_id)   REFERENCES clientes(id),
CONSTRAINT fk_inmueble    FOREIGN KEY  (inmueble_id )     REFERENCES inmueble(id),
CONSTRAINT fk_estado_op   FOREIGN KEY  (estado_id)    REFERENCES estado_op_venta(id),


)ENGINE=Innodb;








CREATE TABLE tareas(

id                  int(255) auto_increment NOT NULL,
oportunidad_venta   int(255),
tarea               text NOT NULL,
fecha_recordatorio  datetime NOT NULL,
id_user             int(255) NOT NULL,
id_estado           int(255) NOT NULL,
created_at		    datetime DEFAULT NULL,
updated_at  	    datetime DEFAULT NULL,
CONSTRAINT pk_tarea PRIMARY KEY (id),

CONSTRAINT fk_op_venta     FOREIGN KEY  (oportunidad_venta ) REFERENCES oportunidad_venta(id),
CONSTRAINT fk_usuario_id     FOREIGN KEY  (id_user ) REFERENCES users(id),
CONSTRAINT fk_estado_tarea     FOREIGN KEY  (id_estado  ) REFERENCES estado_tarea(id),
)ENGINE=Innodb;





-------------------------Nuevos cambios en la base de datos----------------

-- cambios en la tabla obras-> cambio de nombre a inmueble
-- Nuevas tablas proyectos
-- tabla estado_proyecto
-- tabla tipo_inmueble
-- tabla inmueble
-- tabla torre




-- Base de datos de proyectos y obras

CREATE TABLE estado_proyecto(

  id                    int(255) AUTO_INCREMENT NOT NULL,
  nombre                varchar(255) NOT NULL,
  descripcion           text,

  created_at          datetime DEFAULT NULL,
  updated_at          datetime DEFAULT NULL,

  CONSTRAINT pk_estado_proyecto PRIMARY KEY (id)

)ENGINE=INNODB;


CREATE TABLE proyectos(

  id                  int(255) AUTO_INCREMENT NOT NULL,
  nombre              varchar(150) NOT NULL,
  id_user             int(255) NOT NULL,
  id_estado           int(255) NOT NULL,
  fecha_inicio        datetime NOT NULL,
  fecha_finalizacion  datetime NOT NULL,

  direccion           text,
  descripcion         text,
  created_at          datetime DEFAULT NULL,
  updated_at          datetime DEFAULT NULL,

  CONSTRAINT pk_proyectos PRIMARY KEY (id),
  CONSTRAINT fk_user_create FOREIGN KEY (id_user) REFERENCES  users(id),
  CONSTRAINT fk_estado_proyecto FOREIGN KEY (id_estado)   REFERENCES estado_proyecto(id)


)ENGINE=INNODB;


CREATE TABLE torre(

  id                 int (255) AUTO_INCREMENT NOT NULL,
  nombre             varchar(50) NOT NULL,
  cant_pisos         int(255) NOT NULL,
  id_proyecto        int (255)  NOT NULL,

  id_user            int(255) NOT NULL,

  descripcion        text,
  created_at         datetime DEFAULT NULL,
  updated_at         datetime DEFAULT NULL,

  CONSTRAINT  pk_torre PRIMARY KEY (id),
  CONSTRAINT  fk_proyecto FOREIGN KEY (id_proyecto) REFERENCES proyectos(id),
  CONSTRAINT fk_user_create FOREIGN KEY (id_user) REFERENCES  users(id),

)ENGINE=INNODB;


CREATE TABLE tipo_inmueble(

id            int (255) AUTO_INCREMENT NOT NULL,
nombre        varchar(50) NOT NULL,
descripcion   text,

created_at    datetime DEFAULT NULL,
updated_at    datetime DEFAULT NULL,

CONSTRAINT pk_tipo_obra  PRIMARY KEY (id)


)ENGINE=INNODB;




CREATE TABLE inmueble(

id                  int (255) AUTO_INCREMENT NOT NULL,
id_proyecto         int (255) NOT NULL,
id_tipo_inmueble    int (255) NOT NULL,
id_user             int (255) NOT NULL,
id_torre            int (255) NOT NULL,
dimensiones         varchar (255),
habitaciones    int(50),
banos           int(50),
parqueadero     int(50),
cantidad        int(50),
valor_unitario  double(20,3),
descripcion   text,
created_at    datetime DEFAULT NULL,
updated_at    datetime DEFAULT NULL,

CONSTRAINT pk_obras   PRIMARY KEY (id),
CONSTRAINT fk_proyecto FOREIGN KEY (id_proyecto) REFERENCES proyectos(id),
CONSTRAINT fk_torre FOREIGN KEY (id_torre) REFERENCES torre(id),
CONSTRAINT fk_tipo_inmueble FOREIGN KEY (id_tipo_inmueble) REFERENCES  tipo_inmueble(id),
CONSTRAINT fk_create    FOREIGN KEY (id_user) REFERENCES users(id)

)ENGINE=INNODB;


TODO: -- faltaaaa!!!!

CREATE TABLE estado_inmueble()ENGINE=INNODB;
