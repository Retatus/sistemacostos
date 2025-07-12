import { v4 as uuidv4 } from 'uuid';
export default function getPersonaInicial() {
  return {
    id: 0,
    temp_id: uuidv4(),
    nombre: '',    
    apellido_paterno: '',
    apellido_materno: '',
    documento_tipo_id: '',
    documento_numero: '',
    pais_id: '',
    documento_file: '',
    temp_file_name: '',
    temp_file_preview: '',
    tipo_pasajero_id: '',
    clase_id: '',
    cotizacion_id: '',
    estado_activo: 1,
  };
}