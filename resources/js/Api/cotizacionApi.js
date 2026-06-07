import axios from "axios";

const api = axios.create({
  baseURL: "http://127.0.0.1:8000/api", // tu backend Laravel
});

export const getCotizacionEmpty = () => api.get("/cotizaciones/create");

export const getDestinoSelect = () => api.get("/cotizaciones/destino/destino_select");

export const getDestinoSearch = (search) => api.get(`/cotizaciones/destino/destino_search`, { params: { search } });

export const getDestino = (id) => api.get(`/cotizaciones/destino/${id}`);

export const guardarCotizacion = (data) => api.post("/cotizaciones", data);

export const getCotizacionById = (id) => api.get(`/cotizaciones/${id}/edit`);