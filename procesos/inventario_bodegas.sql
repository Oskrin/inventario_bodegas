
CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
SET search_path = public, pg_catalog;
SET client_encoding=LATIN1;
--
-- Estrutura de la tabla 'bodega_productos'
--

DROP TABLE bodega_productos CASCADE;
CREATE TABLE bodega_productos (
id_bodega_productos int4 NOT NULL,
cod_productos int4,
id_bodega int4,
stock_bodega text,
fecha_asignacion text,
hora_asignacion text,
id_usuario int4,
estado text,
existencia text,
diferencia text
);

--
-- Creating data for 'bodega_productos'
--

INSERT INTO bodega_productos VALUES ('3','1','3','1','2014-11-04','2:56:19 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('5','3','3','3','2014-11-04','3:03:58 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('6','2','3','1','2014-11-04','3:03:58 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('7','4','1','1','2014-11-04','3:20:46 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('1','1','1','3','2014-11-04','2:52:53 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('4','2','1','2','2014-11-04','3:01:07 PM','1','Activo',NULL,NULL);
INSERT INTO bodega_productos VALUES ('2','1','2','0','2014-11-04','2:55:41 PM','1','Activo',NULL,NULL);


--
-- Creating index for 'bodega_productos'
--

ALTER TABLE ONLY  bodega_productos  ADD CONSTRAINT  bodega_productos_pkey  PRIMARY KEY  (id_bodega_productos);

--
-- Estrutura de la tabla 'c_cobrarexternas'
--

DROP TABLE c_cobrarexternas CASCADE;
CREATE TABLE c_cobrarexternas (
id_c_cobrarexternas int4 NOT NULL,
id_cliente int4,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
tipo_documento text,
total text,
saldo text,
estado text
);

--
-- Creating data for 'c_cobrarexternas'
--

INSERT INTO c_cobrarexternas VALUES ('2','1','1','2','2','2014-11-06','4:34:40 PM','123','Factura','123.00','123.00','Activo');
INSERT INTO c_cobrarexternas VALUES ('1','1','1','2','1','2014-11-06','4:27:22 PM','001-001-123','Factura','12.00','0.00','Cancelado');


--
-- Creating index for 'c_cobrarexternas'
--

ALTER TABLE ONLY  c_cobrarexternas  ADD CONSTRAINT  c_cobrarexternas_pkey  PRIMARY KEY  (id_c_cobrarexternas);

--
-- Estrutura de la tabla 'bodegas'
--

DROP TABLE bodegas CASCADE;
CREATE TABLE bodegas (
 id_bodega int4 NOT NULL,
nombre_bodega text,
ubicacion text,
telefono text,
movil text,
estado text
);

--
-- Creating data for 'bodegas'
--

INSERT INTO bodegas VALUES ('1','PRINCIPAL','MISMA SUCURSAL','062922670',NULL,'Activo');
INSERT INTO bodegas VALUES ('2','BODEGA1','URCUQUI',NULL,NULL,'Activo');
INSERT INTO bodegas VALUES ('3','BODEGA2','COTACACHI',NULL,NULL,'Activo');


--
-- Creating index for 'bodegas'
--

ALTER TABLE ONLY  bodegas  ADD CONSTRAINT  bodegas_pkey  PRIMARY KEY  (id_bodega);

--
-- Estrutura de la tabla 'c_pagarexternas'
--

DROP TABLE c_pagarexternas CASCADE;
CREATE TABLE c_pagarexternas (
id_c_pagarexternas int4 NOT NULL,
id_proveedor int4,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
tipo_documento text,
total text,
saldo text,
estado text
);

--
-- Creating data for 'c_pagarexternas'
--

INSERT INTO c_pagarexternas VALUES ('1','1','1','2','1','2014-11-06','4:32:21 PM','001-001-000000123','Factura','12.00','0.00','Cancelado');
INSERT INTO c_pagarexternas VALUES ('2','1','1','2','2','2014-11-06','4:34:08 PM','001-001-1123','Factura','122.00','0.00','Cancelado');


--
-- Creating index for 'c_pagarexternas'
--

ALTER TABLE ONLY  c_pagarexternas  ADD CONSTRAINT  c_pagarexternas_pkey  PRIMARY KEY  (id_c_pagarexternas);

--
-- Estrutura de la tabla 'categoria'
--

DROP TABLE categoria CASCADE;
CREATE TABLE categoria (
id_categoria int4 NOT NULL,
nombre_categoria text,
estado text
);

--
-- Creating data for 'categoria'
--

INSERT INTO categoria VALUES ('1','ACCION','Activo');
INSERT INTO categoria VALUES ('2','TERROR','Activo');
INSERT INTO categoria VALUES ('3','INFANTILES','Activo');
INSERT INTO categoria VALUES ('4','COMEDIA','Activo');


--
-- Creating index for 'categoria'
--

ALTER TABLE ONLY  categoria  ADD CONSTRAINT  categoria_pkey  PRIMARY KEY  (id_categoria);

--
-- Estrutura de la tabla 'clientes'
--

DROP TABLE clientes CASCADE;
CREATE TABLE clientes (
id_cliente int4 NOT NULL,
tipo_documento text,
identificacion text,
nombres_cli text,
tipo_cliente text,
direccion_cli text,
telefono text,
celular text,
pais text,
ciudad text,
correo text,
credito_cupo text,
notas text,
estado text
);

--
-- Creating data for 'clientes'
--

INSERT INTO clientes VALUES ('1','Cedula','1002910345','willy','natural','IBARRA',NULL,NULL,'ECUADOR','IBARRA',NULL,'11',NULL,'Activo');


--
-- Creating index for 'clientes'
--

ALTER TABLE ONLY  clientes  ADD CONSTRAINT  clientes_pkey  PRIMARY KEY  (id_cliente);

--
-- Estrutura de la tabla 'color
--

DROP TABLE color CASCADE;
CREATE TABLE color (
id_color int4 NOT NULL,
nombre_color text,
estado text
);

--
-- Creating data for 'color'
--

INSERT INTO color VALUES ('1','AZUL','Activo');
INSERT INTO color VALUES ('2','AMARILLO','Activo');
INSERT INTO color VALUES ('3','NEGRO','Activo');
INSERT INTO color VALUES ('4','CAFE','Activo');
INSERT INTO color VALUES ('5','ROJO','Activo');
INSERT INTO color VALUES ('6','CELESTE','Activo');
INSERT INTO color VALUES ('7','BLANCO','Activo');
INSERT INTO color VALUES ('8','MORADO','Activo');
INSERT INTO color VALUES ('9','VERDE','Activo');
INSERT INTO color VALUES ('10','NARANJA','Activo');
INSERT INTO color VALUES ('11','PLOMO','Activo');


--
-- Creating index for 'color'
--

ALTER TABLE ONLY  color  ADD CONSTRAINT  color_pkey  PRIMARY KEY  (id_color);

--
-- Estrutura de la tabla  'detalle_devolucion_compra'
--

DROP TABLE detalle_devolucion_compra CASCADE;
CREATE TABLE detalle_devolucion_compra (
id_detalle_devcompra int4 NOT NULL,
id_devolucion_compra int4,
cod_productos int4,
cantidad text,
precio_compra text,
descuento_producto text,
total_compra text,
estado text
);

--
-- Creating data for 'detalle_devolucion_compra'
--



--
-- Creating index for 'detalle_devolucion_compra'
--

ALTER TABLE ONLY  detalle_devolucion_compra  ADD CONSTRAINT  detalle_devolucion_compra_pkey  PRIMARY KEY  (id_detalle_devcompra);

--
-- Estrutura de la tabla 'detalle_devolucion_venta'
--

DROP TABLE detalle_devolucion_venta CASCADE;
CREATE TABLE detalle_devolucion_venta (
id_detalle_deventa int4 NOT NULL,
id_devolucion_venta int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_producto text,
total_venta text,
estado text
);

--
-- Creating data for 'detalle_devolucion_venta'
--



--
-- Creating index for 'detalle_devolucion_venta'
--

ALTER TABLE ONLY  detalle_devolucion_venta  ADD CONSTRAINT  detalle_devolucion_venta_pkey  PRIMARY KEY  (id_detalle_deventa);

--
-- Estrutura de la tabla 'detalle_egreso'
--

DROP TABLE detalle_egreso CASCADE;
CREATE TABLE detalle_egreso (
id_detalle_egreso int4 NOT NULL,
id_egresos int4,
cod_productos int4,
cantidad text,
precio_costo text,
descuento text,
total text,
estado text
);

--
-- Creating data for 'detalle_egreso'
--



--
-- Creating index for 'detalle_egreso'
--

ALTER TABLE ONLY  detalle_egreso  ADD CONSTRAINT  detalle_egreso_pkey  PRIMARY KEY  (id_detalle_egreso);

--
-- Estrutura de la tabla 'detalle_factura_compra'
--

DROP TABLE detalle_factura_compra CASCADE;
CREATE TABLE detalle_factura_compra (
id_detalle_compra int4 NOT NULL,
id_factura_compra int4,
cod_productos int4,
cantidad text,
precio_compra text,
descuento_producto text,
total_compra text,
estado text
);

--
-- Creating data for 'detalle_factura_compra'
--



--
-- Creating index for 'detalle_factura_compra'
--

ALTER TABLE ONLY  detalle_factura_compra  ADD CONSTRAINT  detalle_factura_compra_pkey  PRIMARY KEY  (id_detalle_compra);

--
-- Estrutura de la tabla 'detalle_factura_venta'
--

DROP TABLE detalle_factura_venta CASCADE;
CREATE TABLE detalle_factura_venta (
id_detalle_venta int4 NOT NULL,
id_factura_venta int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_producto text,
total_venta text,
estado text,
pendientes text
);

--
-- Creating data for 'detalle_factura_venta'
--

INSERT INTO detalle_factura_venta VALUES ('1','1','2','1','1.00','0','1.00','Activo','0');
INSERT INTO detalle_factura_venta VALUES ('2','2','1','1','1.00','0','1.00','Activo','0');


--
-- Creating index for 'detalle_factura_venta'
--

ALTER TABLE ONLY  detalle_factura_venta  ADD CONSTRAINT  detalle_factura_venta_pkey  PRIMARY KEY  (id_detalle_venta);

--
-- Estrutura de la tabla 'detalle_ingreso'
--

DROP TABLE detalle_ingreso CASCADE;
CREATE TABLE detalle_ingreso (
id_detalle_ingreso int4 NOT NULL,
id_ingresos int4,
cod_productos int4,
cantidad text,
precio_costo text,
descuento text,
total text,
estado text
);

--
-- Creating data for 'detalle_ingreso'
--



--
-- Creating index for 'detalle_ingreso'
--

ALTER TABLE ONLY  detalle_ingreso  ADD CONSTRAINT  detalle_ingreso_pkey  PRIMARY KEY  (id_detalle_ingreso);

--
-- Estrutura de la tabla 'detalle_inventario'
--

DROP TABLE detalle_inventario CASCADE;
CREATE TABLE detalle_inventario (
id_detalle_inventario int4 NOT NULL,
id_inventario int4,
cod_productos int4,
p_costo text,
p_venta text,
disponibles text,
existencia text,
diferencia text,
estado text
);

--
-- Creating data for 'detalle_inventario'
--



--
-- Creating index for 'detalle_inventario'
--

ALTER TABLE ONLY  detalle_inventario  ADD CONSTRAINT  detalle_inventario_pkey  PRIMARY KEY  (id_detalle_inventario);

--
-- Estrutura de la tabla ' detalle_pagos_venta'
--

DROP TABLE  detalle_pagos_venta CASCADE;
CREATE TABLE  detalle_pagos_venta (
id_detalle_pagos_venta int4 NOT NULL,
id_pagos_venta int4,
fecha_pago text,
cuota text,
saldo text,
estado text
);

--
-- Creating data for ' detalle_pagos_venta'
--


--
-- Estrutura de la tabla 'detalle_proforma'
--

DROP TABLE detalle_proforma CASCADE;
CREATE TABLE detalle_proforma (
id_detalle_proforma int4 NOT NULL,
id_proforma int4,
cod_productos int4,
cantidad text,
precio_venta text,
descuento_venta text,
total_venta text,
estado text
);

--
-- Creating data for 'detalle_proforma'
--



--
-- Creating index for 'detalle_proforma'
--

ALTER TABLE ONLY  detalle_proforma  ADD CONSTRAINT  detalle_proforma_pkey  PRIMARY KEY  (id_detalle_proforma);

--
-- Estrutura de la tabla 'detalles_ordenes'
--

DROP TABLE detalles_ordenes CASCADE;
CREATE TABLE detalles_ordenes (
id_detalles_ordenes int4 NOT NULL,
id_ordenes int4,
cod_productos int4,
cantidad text,
precio_costo text,
total_costo text,
estado text
);

--
-- Creating data for 'detalles_ordenes'
--



--
-- Creating index for 'detalles_ordenes'
--

ALTER TABLE ONLY  detalles_ordenes  ADD CONSTRAINT  detalles_ordenes_pkey  PRIMARY KEY  (id_detalles_ordenes);

--
-- Estrutura de la tabla 'detalles_pagos_internos'
--

DROP TABLE detalles_pagos_internos CASCADE;
CREATE TABLE detalles_pagos_internos (
id_detalles_pagos_interna int4 NOT NULL,
id_cuentas_cobrar int4,
fecha_pago_actual text,
total_pagos text,
saldo text,
estado text
);

--
-- Creating data for 'detalles_pagos_internos'
--



--
-- Creating index for 'detalles_pagos_internos'
--

ALTER TABLE ONLY  detalles_pagos_internos  ADD CONSTRAINT  id_detalles_pagos_internos_pkey  PRIMARY KEY  (id_detalles_pagos_interna);

--
-- Estrutura de la tabla 'devolucion_compra'
--

DROP TABLE devolucion_compra CASCADE;
CREATE TABLE devolucion_compra (
id_devolucion_compra int4 NOT NULL,
id_empresa int4,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_comprobante text,
num_serie text,
num_autorizacion text,
tarifa0 text,
tarifa12 text,
iva_compra text,
descuento_compra text,
total_compra text,
observaciones text,
estado text
);

--
-- Creating data for 'devolucion_compra'
--



--
-- Creating index for 'devolucion_compra'
--

ALTER TABLE ONLY  devolucion_compra  ADD CONSTRAINT  devolucion_compra_pkey  PRIMARY KEY  (id_devolucion_compra);

--
-- Estrutura de la tabla 'devolucion_venta'
--

DROP TABLE devolucion_venta CASCADE;
CREATE TABLE devolucion_venta (
id_devolucion_venta int4 NOT NULL,
id_empresa int4,
id_cliente int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_comprobante text,
num_serie text,
tarifa0 text,
tarifa12 text,
iva_venta text,
descuento_venta text,
total_venta text,
observaciones text,
estado text
);

--
-- Creating data for 'devolucion_venta'
--



--
-- Creating index for 'devolucion_venta'
--

ALTER TABLE ONLY  devolucion_venta  ADD CONSTRAINT  devolucion_venta_pkey  PRIMARY KEY  (id_devolucion_venta);

--
-- Estrutura de la tabla 'egresos'
--

DROP TABLE egresos CASCADE;
CREATE TABLE egresos (
id_egresos  int4 NOT NULL,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
origen text,
destino text,
tarifa0 text,
tarifa12 text,
iva_egreso text,
descuento_egreso text,
total_egreso text,
observaciones text,
estado text
);

--
-- Creating data for 'egresos'
--



--
-- Creating index for 'egresos'
--

ALTER TABLE ONLY  egresos  ADD CONSTRAINT  egresos_pkey  PRIMARY KEY  (id_egresos);

--
-- Estrutura de la tabla 'empresa'
--

DROP TABLE empresa CASCADE;
CREATE TABLE empresa (
id_empresa int4 NOT NULL,
nombre_empresa text,
ruc_empresa text,
direccion_empresa text,
telefono_empresa text,
celular_empresa text,
fax_empresa text,
email_empresa text,
pagina_web text,
estado text
);

--
-- Creating data for 'empresa'
--

INSERT INTO empresa VALUES ('1','P&S SYSTEMS','1002050001001','Av. Eugenio Espejo 966 y Bonilla','2585463','0987805075',NULL,'ps.systems@hotmail.com',NULL,'Activo');


--
-- Creating index for 'empresa'
--

ALTER TABLE ONLY  empresa  ADD CONSTRAINT  empresa_pkey  PRIMARY KEY  (id_empresa);

--
-- Estrutura de la tabla 'factura_compra'
--

DROP TABLE factura_compra CASCADE;
CREATE TABLE factura_compra (
id_factura_compra int4 NOT NULL,
id_empresa int4,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
fecha_registro text,
fecha_emision text,
fecha_caducidad text,
tipo_comprobante text,
num_serie text,
num_autorizacion text,
fecha_cancelacion text,
forma_pago text,
tarifa0 text,
tarifa12 text,
iva_compra text,
descuento_compra text,
total_compra text,
estado text
);

--
-- Creating data for 'factura_compra'
--



--
-- Creating index for 'factura_compra'
--

ALTER TABLE ONLY  factura_compra  ADD CONSTRAINT  factura_compra_pkey  PRIMARY KEY  (id_factura_compra);

--
-- Estrutura de la tabla 'factura_venta'
--

DROP TABLE factura_venta CASCADE;
CREATE TABLE factura_venta (
id_factura_venta int4 NOT NULL,
id_empresa int4,
id_cliente int4,
id_usuario int4,
comprobante text,
num_factura text,
fecha_actual text,
hora_actual text,
fecha_cancelacion text,
tipo_precio text,
forma_pago text,
num_autorizacion text,
fecha_autorizacion text,
fecha_caducidad text,
tarifa0 text,
tarifa12 text,
iva_venta text,
descuento_venta text,
total_venta text,
estado text,
fecha_anulacion text
);

--
-- Creating data for 'factura_venta'
--

INSERT INTO factura_venta VALUES ('2','1','1','1','2','001-001-000123124','2014-11-06','4:21:39 PM','2014-11-06','MINORISTA','Contado',NULL,'2014-11-06','2014-11-06','0.00','0.88','0.12','0.00','11','Activo',NULL);
INSERT INTO factura_venta VALUES ('1','1','1','1','1','001-001-123123','2014-11-06','4:19:32 PM','2014-11-06','MINORISTA','Contado',NULL,'2014-11-06','2014-11-06','0.00','0.88','0.12','0.00','11.00','Activo',NULL);


--
-- Creating index for 'factura_venta'
--

ALTER TABLE ONLY  factura_venta  ADD CONSTRAINT  factura_venta_pkey  PRIMARY KEY  (id_factura_venta);

--
-- Estrutura de la tabla 'gastos'
--

DROP TABLE gastos CASCADE;
CREATE TABLE gastos (
id_gastos int4 NOT NULL,
id_usuario int4,
id_factura_venta int4,
comprobante text,
fecha_actual text,
hora_actual text,
descripcion text,
valor text,
saldo text,
acumulado text,
estado text
);

--
-- Creating data for 'gastos'
--



--
-- Creating index for 'gastos'
--

ALTER TABLE ONLY  gastos  ADD CONSTRAINT  gastos_pkey  PRIMARY KEY  (id_gastos);

--
-- Estrutura de la tabla 'gastos_internos'
--

DROP TABLE gastos_internos CASCADE;
CREATE TABLE gastos_internos (
id_gastos int4 NOT NULL,
id_usuario int4,
id_proveedor int4,
comprobante text,
fecha_actual text,
hora_actual text,
num_factura text,
descripcion text,
total text,
estado text
);

--
-- Creating data for 'gastos_internos'
--



--
-- Creating index for 'gastos_internos'
--

ALTER TABLE ONLY  gastos_internos  ADD CONSTRAINT  gastos_internos_pkey  PRIMARY KEY  (id_gastos);

--
-- Estrutura de la tabla 'ingresos'
--

DROP TABLE ingresos CASCADE;
CREATE TABLE ingresos (
id_ingresos int4 NOT NULL,
id_empresa int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
origen text,
destino text,
tarifa0 text,
tarifa12 text,
iva_ingreso text,
descuento_ingreso text,
total_ingreso text,
observaciones text,
estado text
);

--
-- Creating data for 'ingresos'
--



--
-- Creating index for 'ingresos'
--

ALTER TABLE ONLY  ingresos  ADD CONSTRAINT  ingresos_pkey  PRIMARY KEY  (id_ingresos);

--
-- Estrutura de la tabla 'inventario'
--

DROP TABLE inventario CASCADE;
CREATE TABLE inventario (
id_inventario int4 NOT NULL,
id_usuario int4,
id_empresa int4,
comprobante text,
fecha_actual text,
hora_actual text,
estado text
);

--
-- Creating data for 'inventario'
--



--
-- Creating index for 'inventario'
--

ALTER TABLE ONLY  inventario  ADD CONSTRAINT  inventario_pkey  PRIMARY KEY  (id_inventario);

--
-- Estrutura de la tabla 'kardex'
--

DROP TABLE kardex CASCADE;
CREATE TABLE kardex (
id_kardex int4 NOT NULL,
fecha_kardex text,
detalle text,
cantidad_c text,
valor_unitario_c text,
total_c text,
cantidad_v text,
valor_unitario_v text,
total_v  text,
cod_productos  int4,
transaccion  text,
estado text
);

--
-- Creating data for 'kardex'
--



--
-- Creating index for 'kardex'
--

ALTER TABLE ONLY  kardex  ADD CONSTRAINT  kardex_pkey  PRIMARY KEY  (id_kardex);

--
-- Estrutura de la tabla 'kardex_valorizado'
--

DROP TABLE kardex_valorizado CASCADE;
CREATE TABLE kardex_valorizado (
id_kardex int4 NOT NULL,
cod_productos int4,
fecha_transaccion text,
concepto text,
entrada text,
salida text,
existencia text,
costo_unitario text,
costo_promedio text,
debe text,
haber text,
saldo text,
estado text
);

--
-- Creating data for 'kardex_valorizado'
--



--
-- Creating index for 'kardex_valorizado'
--

ALTER TABLE ONLY  kardex_valorizado  ADD CONSTRAINT  kardex_valorizado_pkey  PRIMARY KEY  (id_kardex);

--
-- Estrutura de la tabla 'marcas'
--

DROP TABLE marcas CASCADE;
CREATE TABLE marcas (
id_marca int4 NOT NULL,
nombre_marca text,
estado text
);

--
-- Creating data for 'marcas'
--



--
-- Creating index for 'marcas'
--

ALTER TABLE ONLY  marcas  ADD CONSTRAINT  marcas_pkey  PRIMARY KEY  (id_marca);

--
-- Estrutura de la tabla 'ordenes_produccion'
--

DROP TABLE ordenes_produccion CASCADE;
CREATE TABLE ordenes_produccion (
id_ordenes int4 NOT NULL,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
cod_productos int4,
cantidad text,
sub_total text,
 estado text
);

--
-- Creating data for 'ordenes_produccion'
--



--
-- Creating index for 'ordenes_produccion'
--

ALTER TABLE ONLY  ordenes_produccion  ADD CONSTRAINT  ordenes_produccion_pkey  PRIMARY KEY  (id_ordenes);

--
-- Estrutura de la tabla 'pagos_cobrar'
--

DROP TABLE pagos_cobrar CASCADE;
CREATE TABLE pagos_cobrar (
id_cuentas_cobrar int4 NOT NULL,
id_cliente int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
forma_pago text,
tipo_pago text,
num_factura text,
tipo_factura text,
fecha_factura text,
total_factura text,
valor_pagado text,
saldo_factura text,
observaciones text,
 estado text
);

--
-- Creating data for 'pagos_cobrar'
--

INSERT INTO pagos_cobrar VALUES ('1','1','1','1','2014-11-06','4:37:54 PM','EFECTIVO','EXTERNA','001-001-123','Factura','2014-11-06','12.00','12.00','0.00',NULL,'Activo');


--
-- Creating index for 'pagos_cobrar'
--

ALTER TABLE ONLY  pagos_cobrar  ADD CONSTRAINT  pagos_cobrar_externa_pkey  PRIMARY KEY  (id_cuentas_cobrar);

--
-- Estrutura de la tabla 'pagos_compra'
--

DROP TABLE pagos_compra CASCADE;
CREATE TABLE pagos_compra (
id_pagos_compra int4 NOT NULL,
id_proveedor int4,
id_factura_compra int4,
id_usuario int4,
fecha_credito text,
adelanto text,
meses text,
tipo_documento text,
monto_credito text,
saldo text,
 estado text
);

--
-- Creating data for 'pagos_compra'
--



--
-- Creating index for 'pagos_compra'
--

ALTER TABLE ONLY  pagos_compra  ADD CONSTRAINT  pagos_compra_pkey  PRIMARY KEY  (id_pagos_compra);

--
-- Estrutura de la tabla 'pagos_pagar'
--

DROP TABLE pagos_pagar CASCADE;
CREATE TABLE pagos_pagar (
id_cuentas_pagar int4 NOT NULL,
id_proveedor int4,
id_usuario int4,
comprobante text,
fecha_actual text,
hora_actual text,
forma_pago text,
tipo_pago text,
num_factura text,
tipo_factura text,
fecha_factura text,
total_factura text,
valor_pagado text,
saldo_factura text,
observaciones text,
 estado text
);

--
-- Creating data for 'pagos_pagar'
--

INSERT INTO pagos_pagar VALUES ('1','1','2','1','2014-11-06','4:36:36 PM','EFECTIVO','EXTERNA','001-001-000000123','Factura','2014-11-06','12.00','12.00','0.00',NULL,'Activo');
INSERT INTO pagos_pagar VALUES ('2','1','2','2','2014-11-06','4:37:19 PM','EFECTIVO','EXTERNA','001-001-1123','Factura','2014-11-06','122.00','122.00','0.00',NULL,'Activo');


--
-- Creating index for 'pagos_pagar'
--

ALTER TABLE ONLY  pagos_pagar  ADD CONSTRAINT  pagos_pagar_pkey  PRIMARY KEY  (id_cuentas_pagar);

--
-- Estrutura de la tabla 'pagos_venta'
--

DROP TABLE pagos_venta CASCADE;
CREATE TABLE pagos_venta (
id_pagos_venta int4 NOT NULL,
id_cliente int4,
id_factura_venta int4,
id_usuario int4,
fecha_credito text,
adelanto text,
meses text,
tipo_documento text,
monto_credito text,
saldo text,
 estado text
);

--
-- Creating data for 'pagos_venta'
--



--
-- Creating index for 'pagos_venta'
--

ALTER TABLE ONLY  pagos_venta  ADD CONSTRAINT  pagos_venta_pkey  PRIMARY KEY  (id_pagos_venta);

--
-- Estrutura de la tabla 'productos'
--

DROP TABLE productos CASCADE;
CREATE TABLE productos (
cod_productos int4 NOT NULL,
codigo text,
cod_barras text,
articulo text,
iva text,
series text,
precio_compra text,
utilidad_minorista text,
utilidad_mayorista text,
iva_minorista text,
iva_mayorista text,
categoria text,
marca text,
stock text,
stock_minimo text,
stock_maximo text,
fecha_creacion text,
caracteristicas text,
observaciones text,
descuento text,
estado text,
inventariable text,
 imagen text
);

--
-- Creating data for 'productos'
--

INSERT INTO productos VALUES ('2','TER001',NULL,'TWILIGHT','Si','Si','0.65','54','0','1.00','0.65','TERROR',NULL,'0','1','1','2014-11-04',NULL,NULL,'0','Activo','Si','2.jpg');
INSERT INTO productos VALUES ('3','TER002',NULL,'DARK RIDE','Si','Si','0.65','54','0','1.00','0.65','TERROR',NULL,'2','1','1','2014-11-04',NULL,NULL,'0','Activo','Si','3.jpg');
INSERT INTO productos VALUES ('4','INF001',NULL,'SHREK','Si','Si','0.65','54','0','1.00','0.65','INFANTILES',NULL,'1','1','1','2014-11-04',NULL,NULL,'0','Activo','Si','4.jpg');
INSERT INTO productos VALUES ('1','ACC001',NULL,'INTO THE BLUE','Si','Si','0.65','54','0','1.00','0.65','ACCION',NULL,'0','1','1','2014-11-04',NULL,NULL,'0','Activo','Si','1.jpg');


--
-- Creating index for 'productos'
--

ALTER TABLE ONLY  productos  ADD CONSTRAINT  productos_pkey  PRIMARY KEY  (cod_productos);

--
-- Estrutura de la tabla 'proforma'
--

DROP TABLE proforma CASCADE;
CREATE TABLE proforma (
id_proforma int4 NOT NULL,
id_cliente int4,
id_usuario int4,
id_empresa int4,
comprobante text,
fecha_actual text,
hora_actual text,
tipo_precio text,
tarifa0 text,
tarifa12 text,
iva_proforma text,
descuento_proforma text,
total_proforma text,
observaciones text,
 estado text
);

--
-- Creating data for 'proforma'
--



--
-- Creating index for 'proforma'
--

ALTER TABLE ONLY  proforma  ADD CONSTRAINT  proforma_pkey  PRIMARY KEY  (id_proforma);

--
-- Estrutura de la tabla 'proveedores'
--

DROP TABLE proveedores CASCADE;
CREATE TABLE proveedores (
id_proveedor int4 NOT NULL,
tipo_documento text,
identificacion_pro text,
empresa_pro text,
representante_legal text,
visitador text,
direccion_pro text,
telefono text,
celular text,
fax text,
pais text,
ciudad text,
forma_pago text,
correo text,
principal text,
observaciones text,
 estado text
);

--
-- Creating data for 'proveedores'
--

INSERT INTO proveedores VALUES ('1','Cedula','1004358584','MEGASYSTEM','Oscar Troya ',NULL,'Av. Miguel Egas y Morales','062922670',NULL,NULL,'ECUADOR','IBARRA','Contado','oskrs11@hotmail.com','Si',NULL,'Activo');


--
-- Creating index for 'proveedores'
--

ALTER TABLE ONLY  proveedores  ADD CONSTRAINT  proveedores_pkey  PRIMARY KEY  (id_proveedor);

--
-- Estrutura de la tabla 'seguridad'
--

DROP TABLE seguridad CASCADE;
CREATE TABLE seguridad (
id_seguridad int4 NOT NULL,
clave text,
 estado text
);

--
-- Creating data for 'seguridad'
--

INSERT INTO seguridad VALUES ('1','123','Activo');


--
-- Creating index for 'seguridad'
--

ALTER TABLE ONLY  seguridad  ADD CONSTRAINT  seguridad_pkey  PRIMARY KEY  (id_seguridad);

--
-- Estrutura de la tabla 'serie_venta'
--

DROP TABLE serie_venta CASCADE;
CREATE TABLE serie_venta (
id_serie_venta int4 NOT NULL,
cod_productos int4,
id_factura_venta int4,
serie text,
observacion text,
 estado text
);

--
-- Creating data for 'serie_venta'
--



--
-- Creating index for 'serie_venta'
--

ALTER TABLE ONLY  serie_venta  ADD CONSTRAINT  serie_venta_pkey  PRIMARY KEY  (id_serie_venta);

--
-- Estrutura de la tabla 'series_compra'
--

DROP TABLE series_compra CASCADE;
CREATE TABLE series_compra (
id_serie int4 NOT NULL,
cod_productos int4,
id_factura_compra int4,
serie text,
observacion text,
 estado text
);

--
-- Creating data for 'series_compra'
--



--
-- Creating index for 'series_compra'
--

ALTER TABLE ONLY  series_compra  ADD CONSTRAINT  series_pkey  PRIMARY KEY  (id_serie);

--
-- Estrutura de la tabla 'usuario'
--

DROP TABLE usuario CASCADE;
CREATE TABLE usuario (
id_usuario int4 NOT NULL,
nombre_usuario text,
apellido_usuario text,
ci_usuario text,
telefono_usuario text,
celular_usuario text,
cargo_usuario text,
clave text,
email_usuario text,
direccion_usuario text,
usuario text,
id_bodega int4,
 estado text
);

--
-- Creating data for 'usuario'
--

INSERT INTO usuario VALUES ('1','Oscar','Troya','1004358584','062922670','0989912241','1','123123','oskr_trov@gmail.com','Otavalo','Oscar','1','Activo');
INSERT INTO usuario VALUES ('2','Willy','Narváez','1002910345','062922992','0967404989','2','123123','w_narvaez6@hotmail.com','Otavalo','Willy','2','Activo');
INSERT INTO usuario VALUES ('3','SANTIAGO','YEPEZ','1002050001','0999999999','0987805075','2','123123','','IBARRA','SANTY','3','Activo');


--
-- Creating index for 'usuario'
--

ALTER TABLE ONLY  usuario  ADD CONSTRAINT  usuario_pkey  PRIMARY KEY  (id_usuario);
