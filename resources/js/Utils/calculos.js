
// In calculos.js
const calcularDiferenciaDias = (fechaInicio, fechaFin) => {
    const inicio = new Date(fechaInicio);
    const fin = new Date(fechaFin);
    return Math.round((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;
};

export default calcularDiferenciaDias;

