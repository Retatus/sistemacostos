/**
 * Detecta solo los campos modificados específicos
 * @param {Object} original - Objeto original
 * @param {Object} modificado - Objeto modificado
 * @returns {Object} Campos modificados con valores anterior/nuevo
 */
function detectarCambiosEspecificos(original, modificado) {
  const cambios = {};

  function comparar(obj1, obj2, path = '') {
    // Si son objetos diferentes, comparar sus propiedades
    if (typeof obj1 === 'object' && obj1 !== null &&
      typeof obj2 === 'object' && obj2 !== null) {
      
      const keys = new Set([...Object.keys(obj1), ...Object.keys(obj2)]);

      keys.forEach(key => {
        const fullPath = path ? `${path}.${key}` : key;
        const valor1 = obj1[key];
        const valor2 = obj2[key];

        // Si la propiedad existe en ambos objetos
        if (key in obj1 && key in obj2) {
          // Si son objetos, comparar recursivamente
          if (typeof valor1 === 'object' && valor1 !== null &&
              typeof valor2 === 'object' && valor2 !== null
          ) {
            comparar(valor1, valor2, fullPath);
          } 
          // Si son valores diferentes
          else {
            // --- Uso dentro de tu comparación ---
            const n1 = normalizarValor(valor1);
            const n2 = normalizarValor(valor2);

            if (n1 !== n2) {
              cambios[fullPath] = {
                anterior: valor1,
                nuevo: valor2
              };
            }
          }
        }
      });
    }
  }

  comparar(original, modificado);
  return cambios;
}

function normalizarValor(valor) {
  // ✅ Normalizar booleanos primero
  if (valor === true || valor === false) return valor;
  if (valor === 'true') return true;
  if (valor === 'false') return false;

  // ✅ Normalizar números solo si NO es booleano
  if (!isNaN(valor) && valor !== '') return Number(valor);

  return valor;
}

/**
 * Versión optimizada para auditoría simple
 */
export function auditoriaSimple(original, modificado) {
  const cambios = detectarCambiosEspecificos(original, modificado);
  
  return {
    hayCambios: Object.keys(cambios).length > 0,
    cambios: cambios,
    total: Object.keys(cambios).length,
    timestamp: new Date().toISOString()
  };
}

/**
 * Para campos específicos que queremos monitorear
 */
export function auditarCamposEspecificos(original, modificado, camposAMonitorear = []) {
  const todosCambios = detectarCambiosEspecificos(original, modificado);
  const cambiosFiltrados = {};
  
  // Filtrar solo los campos que nos interesan
  camposAMonitorear.forEach(campo => {
    if (todosCambios[campo]) {
      cambiosFiltrados[campo] = todosCambios[campo];
    }
  });
  
  return {
    hayCambios: Object.keys(cambiosFiltrados).length > 0,
    cambios: cambiosFiltrados,
    timestamp: new Date().toISOString()
  };
}