import { v4 as uuidv4 } from 'uuid';

export default function getPersonaInicial() {
  return {
    id: 1,
    temp_id: uuidv4(),
    nombre: obtenerPasajeroAleatorio().nombres,
    apellido_paterno: obtenerPasajeroAleatorio().apellido_paterno,
    apellido_materno: obtenerPasajeroAleatorio().apellido_materno,
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

function obtenerPasajeroAleatorio() {
  const nombres = [
    "LUIS",
    "ANA",
    "CARLOS",
    "MARÍA",
    "JOSÉ",
    "VALERIA",
    "DIEGO",
    "LUCÍA",
    "ANDRÉS",
    "SOFÍA"
  ];
  const apellidos = [
    "PÉREZ",
    "GÓMEZ",
    "HERNÁNDEZ",
    "LÓPEZ",
    "MARTÍNEZ",
    "GARCÍA",
    "RODRÍGUEZ",
    "SÁNCHEZ",
    "RAMÍREZ",
    "TORO"
  ];

  const indiceAleatorio = Math.floor(Math.random() * nombres.length);
  return { nombres: nombres[indiceAleatorio], apellido_paterno: apellidos[indiceAleatorio], apellido_materno: apellidos[indiceAleatorio] };
}

