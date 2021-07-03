const routes = {
    "inicio": {
        "uri": "\/"
    },
    "home": {
        "uri": "home"
    },
    "fincas": {
        "uri": "home\/fincas"
    },
    "fincas.crear": {
        "uri": "home\/fincas"
    },
    "fincas.editar": {
        "uri": "home\/fincas\/{id}"
    },
    "fincas.update": {
        "uri": "home\/fincas\/{id}"
    },
    "fincas.eliminar": {
        "uri": "home\/fincas\/eliminar\/{id}"
    },
    "admin": {
        "uri": "home\/sisga-admin\/finca\/{id}"
    },
    "series_activas": {
        "uri": "home\/sisga-admin\/finca\/{id}\/series-activas"
    },
    "series_inactivas": {
        "uri": "home\/sisga-admin\/finca\/{id}\/series-inactivas"
    },
    "series_pordestetar": {
        "uri": "home\/sisga-admin\/finca\/{id}\/series-por-destetar"
    },
    "series_hembras_productivas": {
        "uri": "home\/sisga-admin\/finca\/{id}\/series-productivas"
    },
    "especie": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/especie"
    },
    "especie.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/especie"
    },
    "especie.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/especie\/{id}"
    },
    "especie.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/especie\/{id}"
    },
    "especie.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/especie\/{id}"
    },
    "raza": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/raza"
    },
    "raza.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/raza"
    },
    "raza.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/raza\/{id}"
    },
    "raza.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/raza\/{id}"
    },
    "raza.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/raza\/{id}"
    },
    "tipologia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipologias"
    },
    "tipologia.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipologias"
    },
    "tipologia.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipologias\/{id}"
    },
    "tipologia.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipologias\/{id}"
    },
    "tipologia.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipologias\/{id}"
    },
    "condicion_corporal": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/condicion-corporal"
    },
    "condicion_corporal.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/condicion-corporal"
    },
    "condicion_corporal.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/condicion-corporal\/{id}"
    },
    "condicion_corporal.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/condicion-corporal\/{id}"
    },
    "condicion_corporal.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/condicion-corporal\/{id}"
    },
    "diagnostico_palpaciones": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/diagnostico-palpaciones"
    },
    "diagnostico_palpaciones.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/diagnostico-palpaciones"
    },
    "diagnostico_palpaciones.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/diagnostico-palpaciones\/{id}"
    },
    "diagnostico_palpaciones.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/diagnostico-palpaciones\/{id}"
    },
    "diagnostico_palpaciones.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/diagnostico-palpaciones\/{id}"
    },
    "motivo_entrada_salida": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/motivos-entrada-salida"
    },
    "motivo_entrada_salida.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/motivos-entrada-salida"
    },
    "motivo_entrada_salida.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/motivos-entrada-salida\/{id}"
    },
    "motivo_entrada_salida.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/motivos-entrada-salida\/{id}"
    },
    "motivo_entrada_salida.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/motivos-entrada-salida\/{id}"
    },
    "patologia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/patologia"
    },
    "patologia.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/patologia"
    },
    "patologia.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/patologia\/{id}"
    },
    "patologia.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/patologia\/{id}"
    },
    "patologia.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/patologia\/{id}"
    },
    "parametros": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros"
    },
    "parametros_ganaderia.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-ganaderia"
    },
    "parametros_reproduccion.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-reproduccion"
    },
    "parametros_produccion_leche.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-produccion-lechera"
    },
    "parametros_ganaderia.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-ganaderia\/{id}"
    },
    "parametros_reproduccion.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-reproduccion\/{id}"
    },
    "parametros_produccion_leche.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-produccion\/{id}"
    },
    "parametros_ganaderia.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-ganaderia\/{id}"
    },
    "parametros_reproduccion.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-reproduccion\/{id}"
    },
    "parametros_produccion_leche.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/parametros-produccion\/{id}"
    },
    "tipomonta": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipo-monta"
    },
    "tipomonta.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipo-monta"
    },
    "tipomonta.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipo-monta\/{id}"
    },
    "tipomonta.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipo-monta\/{id}"
    },
    "tipomonta.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tipo-monta\/{id}"
    },
    "causamuerte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/causa-de-muerte"
    },
    "causamuerte.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/causa-de-muerte"
    },
    "causamuerte.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/causa-de-muerte\/{id}"
    },
    "causamuerte.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/causa-de-muerte\/{id}"
    },
    "causamuerte.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/causa-de-muerte\/{id}"
    },
    "destinosalida": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/destino-salida"
    },
    "destinosalida.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/destino-salida"
    },
    "destinosalida.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/destino-salida\/{id}"
    },
    "destinosalida.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/destino-salida\/{id}"
    },
    "destinosalida.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/destino-salida\/{id}"
    },
    "procedencia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/procedencia"
    },
    "procedencia.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/procedencia"
    },
    "procedencia.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/procedencia\/{id}"
    },
    "procedencia.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/procedencia\/{id}"
    },
    "procedencia.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/procedencia\/{id}"
    },
    "salaordeno": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/sala-de-ordeno"
    },
    "salaordeno.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/sala-de-ordeno"
    },
    "salaordeno.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/sala-de-ordeno\/{id}"
    },
    "salaordeno.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/sala-de-ordeno\/{id}"
    },
    "salaordeno.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/sala-de-ordeno\/{id}"
    },
    "tanque": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tanque-enfriamiento"
    },
    "tanque.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tanque-enfriamiento"
    },
    "tanque.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tanque-enfriamiento\/{id}"
    },
    "tanque.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tanque-enfriamiento\/{id}"
    },
    "tanque.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/tanque-enfriamiento\/{id}"
    },
    "colores": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/colores-campo"
    },
    "colores.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/colores-campo"
    },
    "colores.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/colores-campo\/{id}"
    },
    "colores.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/colores-campo\/{id}"
    },
    "colores.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/colores-campo\/{id}"
    },
    "ficha": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado"
    },
    "filterSexo": {
        "uri": "home\/ganaderia\/ficha-de-ganado\/sexo\/{sexo}"
    },
    "fichaganado.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado"
    },
    "fichaganado.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/{serie}"
    },
    "fichaganado.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/{serie}"
    },
    "catalogodeganado.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/reportes\/catalogo-de-ganado"
    },
    "catalogoganadoinactivo.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/reportes\/catalogo-de-ganado-inactivo"
    },
    "ganadopordestete.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/reportes\/catalogo-de-ganado-por-destetar"
    },
    "catalogohemrepro.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/reportes\/catalogo-de-ganado-hembras-reproductivas"
    },
    "pesoespecifico.mostrar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/peso-especifico\/{serie}"
    },
    "pesoespecifico.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/peso-especifico\/{serie}"
    },
    "pesoespecifico.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/eliminar-peso-especifico\/{id_peso}"
    },
    "pesoespecifico.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/ficha-de-ganado\/peso-especifico\/reportes\/{serie}"
    },
    "lote": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote"
    },
    "lote.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote"
    },
    "lote.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/{id}"
    },
    "lote.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/{id}"
    },
    "lote.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/{id}"
    },
    "sublote": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/crear-sub-lote\/{id}"
    },
    "sublote.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/crear-sub-lote\/{id}"
    },
    "sublote.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/crear-sub-lote\/eliminar\/{id}"
    },
    "cambio_tipologia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/cambio-de-tipologia"
    },
    "tipologia.cambiar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/peso"
    },
    "filterTipologia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/cambio-de-tipologia\/filtro\/{id_tipo}"
    },
    "seriesenlote": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/series-en-lote\/{id}"
    },
    "seriesensublote": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/lote\/series-en-sublote\/{id}"
    },
    "asignarseries": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/asignar-series"
    },
    "filterName": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/asignar-series\/{nombre_lote}"
    },
    "filterTipo": {
        "uri": "home\/ganaderia\/asignar-series\/tipo\/{tipo}"
    },
    "serielote.asignar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/asignar-series"
    },
    "transferencia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/transferencia"
    },
    "serie.transferir": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/transferencia"
    },
    "reportes_transferencia": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-reportes-transferencia-de-series"
    },
    "transferencia.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reportes-transferencia"
    },
    "salida": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/salida-de-series"
    },
    "serie.salida": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/salida-de-series"
    },
    "salida.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reportes-salida-de-series"
    },
    "pajuela": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/pajuela"
    },
    "pajuela.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/pajuela"
    },
    "pajuela.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/pajuela\/{id}"
    },
    "pajuela.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/pajuela\/{id}"
    },
    "pajuela.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/pajuela\/eliminar\/{id}"
    },
    "peso_ajustado": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/peso-ajustado"
    },
    "calcular_peso_ajustado": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/calcular-peso-ajustado"
    },
    "reportes_pesoajustado": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-reportes-de-ajuste-de-peso"
    },
    "pesoajustado.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reportes-peso-ajustado"
    },
    "pa.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reportes-de-ajuste-de-peso"
    },
    "reportes_generales": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reportes-generales"
    },
    "reportes_catalogodeganado": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-catalogo-de-ganado"
    },
    "catalago.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reportes-catalogo-de-ganado"
    },
    "reportes_pajuela": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-pajuela"
    },
    "pajuela.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reporte-pajuela"
    },
    "reportes_histsalida": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-historial-salida"
    },
    "histsal.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reporte-historial-salida"
    },
    "reportes_movimientolote": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/vista-movimiento-lote"
    },
    "movimientolote.reporte": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/ganaderia\/reporte-movimiento-lote"
    },
    "temporada_monta": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva"
    },
    "temporada.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva"
    },
    "temporada.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva\/{id}"
    },
    "temporada.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva\/{id}"
    },
    "temporada.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva\/eliminar\/{id}"
    },
    "temporada.cerrar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-cierre\/{id}"
    },
    "temporada.detalle": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}"
    },
    "ciclo": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo"
    },
    "ciclo.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/crear-ciclo"
    },
    "ciclo.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/editar-ciclo\/{id_ciclo}"
    },
    "ciclo.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/editar-ciclo\/{id_ciclo}"
    },
    "ciclo.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva\/{id}\/eliminar-ciclo\/{id_ciclo}"
    },
    "ciclo.detalle": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}"
    },
    "lotemonta": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/lote-de-monta"
    },
    "lotemonta.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/lote-de-monta"
    },
    "lotemonta.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/editar-lote-de-monta\/{id_lotemonta}"
    },
    "lotemonta.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/editar-lote-de-monta\/{id_lotemonta}"
    },
    "lotemonta.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/eliminar-lote-de-monta\/{id_lotemonta}"
    },
    "serieslotemonta": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/series-en-lote-de-monta"
    },
    "asignarserieslotemonta": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/ciclo\/{id_ciclo}\/asignando-series-en-lote-de-monta"
    },
    "celos": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/celo"
    },
    "celos.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-celo"
    },
    "celos.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/editar-celo\/{id_celo}"
    },
    "celos.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/actualizar-registro-de-celo\/{id_celo}"
    },
    "celos.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-celo\/{id_celo}"
    },
    "servicio": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/servicio"
    },
    "servicio.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-servicio"
    },
    "servicio.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/editar-servicio\/{id_servicio}"
    },
    "servicio.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/actualizar-registro-de-servicio\/{id_servicio}"
    },
    "servicio.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-servicio\/{id_servicio}"
    },
    "palpacion": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/palpaciones"
    },
    "palpacion.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-palpacion"
    },
    "palpacion.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/editar-palpacion\/{id_palpacion}"
    },
    "palpacion.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/actualizar-registro-de-palpacion\/{id_palpacion}"
    },
    "palpacion.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-palpacion\/{id_palpacion}"
    },
    "prenez": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/prenez"
    },
    "prenez.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-prenez"
    },
    "prenez.editar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/editar-prenez\/{id_prenez}"
    },
    "prenez.update": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/actualizar-registro-de-prenez\/{id_prenez}"
    },
    "prenez.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-prenez\/{id_prenez}"
    },
    "parto": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/parto"
    },
    "parto.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-parto"
    },
    "parto.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-parto\/{id_parto}"
    },
    "aborto": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/aborto"
    },
    "aborto.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-aborto"
    },
    "aborto.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-aborto\/{id_aborto}"
    },
    "partonc": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/parto-no-concluido"
    },
    "partonc.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/crear-parto-no-concluido"
    },
    "partonc.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/serie\/{id_serie}\/eliminar-registro-de-parto-no-concluido\/{id_partonc}"
    },
    "seriemonta.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reproduccion\/temporada-reproductiva-detalle\/{id}\/detalle-de-monta\/{id_ciclo}\/retirar-serie\/{id_serie}"
    },
    "inventario": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/inventario\/trabajo-de-campo"
    },
    "tc.crear": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/inventario\/crear-trabajo-de-campo"
    },
    "tc.detalle": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/inventario\/trabajo-de-campo\/detalle\/{id_tc}"
    },
    "tc.guardar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/inventario\/guardar-trabajo-de-campo\/{id_tc}"
    },
    "tc.eliminar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/inventario\/eliminar-trabajo-de-campo\/{id_tc}"
    },
    "vistacomparar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/comparar\/trabajo-de-campo"
    },
    "imprimircomparar": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/comparar\/trabajo-de-campo-print"
    },
    "blocknotas": {
        "uri": "home\/sisga-admin\/block-notas"
    },
    "blocknotas.crear": {
        "uri": "home\/sisga-admin\/block-notas"
    },
    "blocknotas.editar": {
        "uri": "home\/sisga-admin\/block-notas-detalles\/{id}"
    },
    "blocknotas.update": {
        "uri": "home\/sisga-admin\/block-notas-update\/{id}"
    },
    "blocknotas.eliminar": {
        "uri": "home\/sisga-admin\/block-notas-eliminar\/{id}"
    },
    "blocknotasitem.crear": {
        "uri": "home\/sisga-admin\/block-notas-item"
    },
    "blocknotasitem.editar": {
        "uri": "home\/sisga-admin\/editar-block-notas-item"
    },
    "blocknotasitem.eliminar": {
        "uri": "home\/sisga-admin\/block-notas-item-eliminar\/{id}"
    },
    "blocknotasitem.guardar": {
        "uri": "home\/sisga-admin\/block-notas-detalles-item\/{id}"
    },
    "roles": {
        "uri": "home\/sisga-admin\/roles"
    },
    "personreport": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/reporte-personalizado"
    },
    "print_report": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/print-reporte-personalizado-ganaderia"
    },
    "print_report_reproducion": {
        "uri": "home\/sisga-admin\/finca\/{id_finca}\/print-reporte-personalizado-reproduccion"
    },
    "login": {
        "uri": "login"
    },
    "logout": {
        "uri": "logout"
    },
    "register": {
        "uri": "register"
    },
    "password.request": {
        "uri": "password\/reset"
    },
    "password.email": {
        "uri": "password\/email"
    },
    "password.reset": {
        "uri": "password\/reset\/{token}"
    },
    "password.update": {
        "uri": "password\/reset"
    },
    "password.confirm": {
        "uri": "password\/confirm"
    }
};

const route = (routeName, params = [], absolute = true) => {
  const _route = routes[routeName];
  if (_route == null) throw "Requested route doesn't exist";

  let uri = _route.uri;

  const matches = uri.match(/{[\w]+\??}/g) || [];
  const optionals = uri.match(/{[\w]+\?}/g) || [];

  const requiredParametersCount = matches.length - optionals.length;

  if (params instanceof Array) {
    if (params.length < requiredParametersCount) throw "Missing parameters";

    for (let i = 0; i < requiredParametersCount; i++)
      uri = uri.replace(/{[\w]+\??}/, params.shift());

    for (let i = 0; i < params.length; i++)
      uri += (i ? "&" : "?") + params[i] + "=" + params[i];
  } else if (params instanceof Object) {
    let extraParams = matches.reduce((ac, match) => {
      let key = match.substring(1, match.length - 1);
      let isOptional = key.endsWith("?");
      if (params.hasOwnProperty(key.replace("?", ""))) {
        uri = uri.replace(new RegExp(match.replace("?", "\\?"), "g"), params[key.replace("?", "")]);
        delete ac[key.replace("?", "")];
      } else if (isOptional) {
          uri = uri.replace("/" + new RegExp(match, "g"), "");
      }
      return ac;
    }, params);

    Object.keys(extraParams).forEach((key, i) => {
      uri += (i ? "&" : "?") + key + "=" + extraParams[key];
    });
  }

  if (optionals.length > 0) {
    for (let i in optionals) {
      uri = uri.replace("/" + optionals[i], "");
    }
  }

  if (uri.includes("}")) throw "Missing parameters";

  if (absolute && process.env.MIX_APP_URL)
    return process.env.MIX_APP_URL + "/" + uri;
  return "/" + uri;
};

export { route };
