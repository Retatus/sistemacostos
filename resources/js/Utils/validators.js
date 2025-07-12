// resources/js/Utils/validators.js

/**
 * Valida input numérico (solo números y un punto decimal)
 * @param {string} value - Valor a validar
 * @returns {string} Valor validado
 */
export const validateNumberInput = (value) => {
  const validValue = value.replace(/[^0-9.]/g, "");
  const decimalParts = validValue.split(".");
  if (decimalParts.length > 2) {
      return `${decimalParts[0]}.${decimalParts[1]}`;
  }
  return validValue;
};

// Otras funciones de validación que necesites
export const validateEmail = (email) => {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
};