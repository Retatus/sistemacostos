
// In calculos.js
export const calcularDiferenciaDias = (fechaInicio, fechaFin) => {
    const inicio = new Date(fechaInicio);
    const fin = new Date(fechaFin);
    return Math.round((fin - inicio) / (1000 * 60 * 60 * 24)) + 1;
};

export const calcularFechaFin = (fechaInicio, dias) => {
    const inicio = new Date(fechaInicio);
    const fechaFin = new Date(inicio.getTime() + (dias - 1) * 24 * 60 * 60 * 1000);
    return fechaFin.toISOString().split('T')[0];
};