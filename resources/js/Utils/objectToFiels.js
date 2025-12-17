// objetoForm.js
export function generateFieldsFromObject(obj) {
    return Object.keys(obj).map(key => {
        let field = { name: key, label: key.toUpperCase(), type: "text" };

        if (typeof obj[key] === "number") {
            field.type = "number";
            field.placeholder = `Ingrese ${key}`;
        } else if (typeof obj[key] === "string") {
            field.type = "text";
            field.placeholder = `Ingrese ${key}`;
        } else if (Array.isArray(obj[key])) {
            field.type = "array";
            field.placeholder = `Lista de ${key}`;
        } else if (typeof obj[key] === "object") {
            field.type = "object";
            field.placeholder = `Objeto ${key}`;
        }

        if (key === "moneda") {
            field.type = "select";
            field.options = [
                { value: 'USD', label: 'USD' },
                { value: 'PEN', label: 'PEN' }
            ];
        }

        if (key === "observacion") {
            field.type = "textarea";
            field.placeholder = "Observación de la categoría";
        }

        if (key === "estatus") {
            field.type = "select";
            field.options = [
                { value: '0', label: 'PENDIENTE' },
                { value: '1', label: 'CONFIRMADA' },
                { value: '2', label: 'CANCELADA' },
                { value: '3', label: 'XPASAJERO' }
            ];
        }

        return field;
    });
}