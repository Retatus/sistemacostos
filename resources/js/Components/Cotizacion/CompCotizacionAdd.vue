<template>
    <div class="container mx-auto px-2">
    <form @submit.prevent="submitCotizacion" class="py-6 space-y-6">       
        <!-- TARJETA 2: INFORMACIÓN DE CLIENTE, Y DATOS DE LA COTIZACIÓN -->
         <div class="grid md:grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Columna Izquierda -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </i>
                    Datos del Cliente
                </h3> 
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div hidden class="md:col-span-3 lg:col-span-2">
                        <label for="cliente_nro_doc" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Cliente Id
                        </label>
                        <input v-model="Cotizacion.cliente_nro_doc" type="text" id="cliente_nro_doc" 
                            required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Ej: 12345678">
                    </div>
                    <!-- Documento del Cliente -->
                    <div class="md:col-span-3 lg:col-span-2">
                        <label for="cliente_nro_doc" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Documento
                        </label>
                        <input v-model="Cotizacion.cliente_nro_doc" type="text" id="cliente_nro_doc" 
                            required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Ej: 12345678">
                    </div>
                    
                    <!-- Nombre del Cliente -->
                    <div class="md:col-span-6 lg:col-span-7">
                        <label for="proveedor_razon_social" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Nombre del Cliente
                        </label>
                        <input v-model="Cotizacion.proveedor_razon_social" type="text" 
                            id="proveedor_razon_social" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Nombre completo o razón social">
                    </div>
                    
                    <!-- Botón Nuevo -->
                    <div class="md:col-span-3 lg:col-span-3 flex items-end">
                        <button type="button" @click="showModalProveedor = true"
                                class="w-full px-4 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Nuevo
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </i>
                    Datos de la Cotización
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Número de File -->
                    <div class="md:col-span-3 lg:col-span-2">
                        <label for="file_nro" class="block text-sm font-medium text-gray-700 mb-1">
                            N° File
                        </label>
                        <input v-model="Cotizacion.file_nro" type="text" id="file_nro" disabled
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg cursor-not-allowed"
                            placeholder="Auto-generado">
                    </div>
                    
                    <!-- Nombre de File -->
                    <div class="md:col-span-6 lg:col-span-5">
                        <label for="file_nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Nombre del File
                        </label>
                        <input v-model="Cotizacion.file_nombre" type="text" id="file_nombre" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Ej: Tour Cusco 2024">
                    </div>
                    
                    <!-- Estado de Cotización -->
                    <div class="md:col-span-3 lg:col-span-5">
                        <label for="estado_cotizacion" class="block text-sm font-medium text-gray-700 mb-1">
                            Estado de Cotización
                        </label>
                        <select v-model="Cotizacion.estado_cotizacion"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-medium">
                            <option disabled value="0">Seleccionar estado...</option>
                            <option v-for="option in EstadoCotizacion" :key="option.value" :value="option.value"
                                    :class="{
                                        'text-yellow-600': option.value === 'pendiente',
                                        'text-green-600': option.value === 'confirmada',
                                        'text-red-600': option.value === 'cancelada'
                                    }">
                                {{ option.label }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- TARJETA 3: INFORMACIÓN GENERAL -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Columna Izquierda -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </i>
                    Información general
                </h3>                    
                
                <div class="space-y-4">
                    <!-- Fila 1: Comprobante y Fecha -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="comprobante_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo Comprobante
                            </label>
                            <select v-model="Cotizacion.comprobante_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option disabled value="0">Seleccionar...</option>
                                <option v-for="option in sTipoComprobante" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                        
                        <div>
                            <Datepicker label="Fecha" :modelValue="Cotizacion.fecha"
                                @update:modelValue="Cotizacion.fecha = $event" :disabled="true"/>
                        </div>
                    </div>
                    
                    <!-- Fila 2: Idiomas y Mercado -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="idioma" class="block text-sm font-medium text-gray-700 mb-1">
                                Idioma
                            </label>
                            <select v-model="Cotizacion.idioma_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option disabled value="0">Seleccionar...</option>
                                <option v-for="option in sIdioma" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="mercado" class="block text-sm font-medium text-gray-700 mb-1">
                                Mercado
                            </label>
                            <select v-model="Cotizacion.mercado_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option disabled value="0">Seleccionar...</option>
                                <option v-for="option in sMercado" :key="option.value" :value="option.value">
                                    {{ option.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-calculator text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </i>
                        Pasajeros
                    </h3>
                    
                    <button v-if="Cotizacion.nro_pasajeros > 0" type="button" @click="agregarDetalleDatosPasajero"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-user-plus">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </i>
                        Datos del Pasajero
                    </button>
                </div>              
                
                <div class="space-y-4">
                    <!-- Total Pasajeros -->
                    <div>
                        <h3 for="nro_pasajeros" class="block text-sm font-medium text-gray-700 mb-1">
                            Total de Pasajeros
                        </h3>
                        <div class="relative">
                            <input v-model="Cotizacion.nro_pasajeros" type="text" id="nro_pasajeros" readonly
                                   class="w-full px-3 py-2 bg-blue-50 border border-blue-200 rounded-lg font-semibold text-blue-700 text-center">
                            <div class="absolute right-3 top-2">
                                <i class="fas fa-users text-blue-500"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contadores -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                <i class="text-yellow-500 mr-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </i>
                                Niños
                            </label>
                            <ContadorInput v-model="Cotizacion.nro_ninio" id="nro_ninio" 
                                placeholder="0" :required="true"
                                @accion-realizada="manejarAccion"
                                class="[&_button]:bg-yellow-100 [&_button]:text-yellow-700 [&_input]:bg-yellow-50" />
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                <i class="text-green-500 mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </i>
                                Adultos
                            </label>
                            <ContadorInput v-model="Cotizacion.nro_adulto" id="nro_adulto"
                                placeholder="0" :required="true"
                                @accion-realizada="manejarAccion"
                                class="[&_button]:bg-green-100 [&_button]:text-green-700 [&_input]:bg-green-50" />
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                <i class="text-purple-500 mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </i>
                                Estudiantes
                            </label>
                            <ContadorInput v-model="Cotizacion.nro_estudiante" id="nro_estudiante"
                                placeholder="0" :required="true"
                                @accion-realizada="manejarAccion"
                                class="[&_button]:bg-purple-100 [&_button]:text-purple-700 [&_input]:bg-purple-50" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TARJETA 4: DESTINO Y FECHAS -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i class="text-sky-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                    </svg>
                </i>
                Destino
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Destino Turístico -->
                <div class="md:col-span-8">
                    <label for="destino_turistico_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Destino Turístico
                    </label>
                    <select v-model="Cotizacion.destino_turistico_id" @change="ListaCategoriaProveedor"
                            class="w-full px-3 py-2 border border-cyan-300 bg-cyan-50 rounded-lg text-cyan-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option disabled value="0">Seleccionar destino...</option>
                        <option v-for="option in DestinoTuristico" :key="option.value" :value="option.value">
                            📍{{ option.label }}
                        </option>
                    </select>
                </div>
                
                <!-- País -->
                <div class="md:col-span-4">
                    <label for="pais_id" class="block text-sm font-medium text-gray-700 mb-1">
                        País
                    </label>
                    <select v-model="Cotizacion.pais_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option disabled value="0">Seleccionar...</option>
                        <option v-for="option in sPais" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i class="text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </i>
                Fechas
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Fechas -->
                <div class="md:col-span-5">
                    <Datepicker label="Inicio" :modelValue="Cotizacion.fecha_inicio"
                        @update:modelValue="Cotizacion.fecha_inicio = $event"
                        @fecha-cambiada="manejarCambioFecha"
                        :emitirEventoCambio="true"/>
                </div>
                
                <div class="md:col-span-5">
                    <Datepicker label="Fin" :modelValue="Cotizacion.fecha_fin"
                        @update:modelValue="Cotizacion.fecha_fin = $event" :disabled="true"/>
                </div>
                
                <div class="md:col-span-2">
                    <label for="nro_dias" class="block text-sm font-medium text-gray-700 mb-1">
                        Días
                    </label>
                    <input disabled v-model="Cotizacion.nro_dias" type="text" id="nro_dias"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-center font-semibold"
                            placeholder="0">
                </div>
            </div>
        </div>
        </div>
        
        
        <!-- TARJETA 5: DETALLE DE SERVICIOS -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                <i class="text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </i>
                Detalle de Servicios
            </h3>
            
            <div v-for="(dia, indexDia) in serviciosPorDia" :key="indexDia" class="day-group mb-6">
            <!-- HEADER DEL DÍA -->
            <div class="day-header bg-gradient-to-r from-teal-600 to-teal-700 text-white bg p-3 rounded-lg mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 shadow-md">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-semibold truncate">Día {{ dia.nro_dia }}: {{ dia.nombre }}</h3>
                </div>
                
                <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-end">
                    <button type="button" @click="toggleTable(indexDia)" 
                        class="px-3 py-1.5 bg-orange-400 hover:bg-orange-700 text-white text-sm rounded-lg transition-colors flex items-center gap-1">
                        <svg v-if="dia.isVisible" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg> 
                        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                    
                    <button type="button" @click="" 
                            class="px-3 py-1.5 bg-green-400 hover:bg-green-700 text-white text-sm rounded-lg transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </button>
                    
                    <button type="button" @click="eliminarItinerario(indexDia)"
                            class="px-3 py-1.5 bg-red-400 hover:bg-red-700 text-white text-sm rounded-lg transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- TABLA RESPONSIVE -->
            <Transition name="fade-slide">
                <div v-show="dia.isVisible" class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-[1200px] divide-y divide-gray-300 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <!-- COLUMNA 1: Hora -->
                                <th class="sticky left-0 z-10 bg-gray-100 px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[80px] max-w-[100px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Hora</span>
                                        <span class="text-xs font-normal text-gray-500">Editar</span>
                                    </div>
                                </th>
                                
                                <!-- COLUMNA 2: Detalles del Servicio -->
                                <th class="px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[470px] max-w-[470px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Detalles del Servicio</span>
                                        <span class="text-xs font-normal text-gray-500">Categoría / Proveedor / Servicio</span>
                                    </div>
                                </th>
                                
                                <!-- COLUMNA 3: Observación -->
                                <th class="px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[150px] max-w-[150px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Observación</span>
                                        <span class="text-xs font-normal text-gray-500">Notas / Configuración</span>
                                    </div>
                                </th>
                                
                                <!-- COLUMNA 4: Financiero -->
                                <th class="px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[180px] max-w-[220px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Detalles Financieros</span>
                                        <span class="text-xs font-normal text-gray-500">Moneda / Monto / Cant. / Subtotal</span>
                                    </div>
                                </th>
                                
                                <!-- COLUMNA 5: Pasajeros -->
                                <th class="px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[150px] max-w-[180px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Pasajeros</span>
                                        <span class="text-xs font-normal text-gray-500">Asignados</span>
                                    </div>
                                </th>
                                
                                <!-- COLUMNA 6: Estado y Acciones -->
                                <th class="px-4 py-3 border-r border-gray-300 font-medium text-gray-900 min-w-[180px] max-w-[220px]">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">Estado</span>
                                        <span class="text-xs font-normal text-gray-500">y Acciones</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(servicioDetalle, indexItinerario) in dia.itinerario_servicios" 
                                :key="servicioDetalle.id"
                                class="hover:bg-gray-50/50 transition-colors duration-150">
                                
                                <!-- CELDA 1: Hora (Sticky) -->
                                <td class="sticky left-0 z-10 bg-white px-4 py-3 border-r border-gray-300 min-w-[50px] max-w-[100px]">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                            class="size-5 text-gray-500 mb-1 text-center">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>                                                                          
                                        <InputHora v-model="servicioDetalle.pasajero_servicios.hora" 
                                            class="w-full text-sm text-center py-1.5 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <!-- <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Hospedaje
                                    </span> -->
                                </td>
                                
                                <!-- CELDA 2: Detalles del Servicio -->
                                <td class="px-4 py-3 border-r border-gray-300 min-w-[300px] max-w-[350px]">
                                    <div class="space-y-2">
                                        <!-- Categoría -->
                                        <div class="flex items-center gap-2">
                                            <label class="text-xs text-gray-500 min-w-[40px]">Cat:</label>
                                            <select v-model="servicioDetalle.proveedor_categoria_id"
                                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                                <option disabled value="0">Seleccionar categoría</option>
                                                <option v-for="option in sCategoriaProveedor" 
                                                        :key="option.value"
                                                        :value="option.value"
                                                        class="py-1">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                        </div>
                                        
                                        <!-- Proveedor -->
                                        <div class="flex items-center gap-2">
                                            <label class="text-xs text-gray-500 min-w-[40px]">Prov:</label>
                                            <div class="w-full px-2 py-1.5 bg-gray-50 rounded border border-gray-200">
                                                <span class="text-sm text-gray-800 font-medium truncate block">
                                                    {{ servicioDetalle.servicio?.proveedor?.razon_social || 'Sin proveedor' }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Servicio -->
                                        <div class="flex items-center gap-2">
                                            <label class="text-xs text-gray-500 min-w-[40px]">Serv:</label>
                                            <select v-model="servicioDetalle.servicio_id"
                                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                                    @change="handleChange(dia.nro_dia, indexItinerario)">
                                                <option disabled value="0">Seleccionar servicio</option>
                                                <option v-for="item in servicios" 
                                                        :key="item.value"
                                                        :value="item.value"
                                                        class="py-1">
                                                    {{ item.label }}
                                                </option>
                                                <option value='__add_new__' 
                                                        class="text-green-600 font-medium bg-green-50 py-1">
                                                    ➕ Agregar nuevo servicio
                                                </option>
                                            </select>
                                        </div>
                                        <div v-if="servicioDetalle.proveedor_categoria_id === 2 && servicioDetalle.servicio.precios[0].tipo_costo === 'HABITACION'">
                                            <button type="button" class="text-xs text-blue-600 hover:underline"
                                                @click="editarAlojamiento(dia.nro_dia, indexItinerario)">
                                                Cambiar
                                            </button>
                                            <HotelHabitacionManual
                                                :pasajeros="Cotizacion.nro_pasajeros"
                                                :habitacionesDisponibles="servicioDetalle.catalogoHabitaciones"
                                                @update="(seleccion) => actualizarDistribucion(seleccion, dia.nro_dia, indexItinerario)"
                                                @cambiarProveedor="(p) => seleccionarProveedor(p, servicioDetalle)"
                                                class="text-sm"
                                            />
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- CELDA 3: Observación -->
                                <td class="px-4 py-3 border-r border-gray-300 min-w-[350px] max-w-[350px]">
                                    <div class="h-full">                                        
                                        <textarea v-model="servicioDetalle.pasajero_servicios.observacion"
                                                name="observacion"
                                                class="w-full h-full min-h-[80px] border border-gray-300 rounded px-3 py-2 text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                                placeholder="Ingrese observaciones aquí..."
                                                rows="3">
                                        </textarea>
                                    </div>                                    
                                </td>
                                
                                <!-- CELDA 4: Detalles Financieros -->
                                <td class="px-4 py-3 border-r border-gray-300 min-w-[180px] max-w-[220px]">
                                    <div class="space-y-3">
                                        <!-- Moneda y Monto -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="text-xs text-gray-500 block mb-1">Moneda</label>
                                                <select v-model="servicioDetalle.pasajero_servicios.moneda"
                                                        class="w-full border rounded px-2 py-1.5 text-sm font-medium transition-all focus:ring-2 focus:ring-opacity-50"
                                                        :class="{
                                                            'border-blue-500 bg-blue-50 text-blue-800 focus:ring-blue-500': servicioDetalle.pasajero_servicios.moneda === 'USD',
                                                            'border-green-500 bg-green-50 text-green-800 focus:ring-green-500': servicioDetalle.pasajero_servicios.moneda === 'PEN'
                                                        }">
                                                    <option value="USD">USD</option>
                                                    <option value="PEN">PEN</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-500 block mb-1">Monto</label>
                                                <input type="text" 
                                                    v-model="servicioDetalle.pasajero_servicios.monto"
                                                    @input="handleMontoInput($event, dia.id, servicioDetalle.id)"
                                                    @blur="formatMonto(dia.id, servicioDetalle.id)"
                                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-right text-sm focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                        
                                        <!-- Cantidad y Subtotal -->
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="text-xs text-gray-500 block mb-1">Cantidad</label>
                                                <input type="number"
                                                    v-model="servicioDetalle.pasajero_servicios.cantidad_pasajeros"
                                                    min="1"
                                                    @input="calcularSubtotal(dia.id, servicioDetalle.id)"
                                                    class="w-full border border-gray-300 rounded px-2 py-1.5 text-right text-sm focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <label class="text-xs text-gray-500 block mb-1">Subtotal</label>
                                                <div class="font-semibold text-gray-900 text-right text-sm bg-gray-50 rounded px-2 py-1.5 border border-gray-200 truncate">
                                                    {{ calcularSubtotalDisplay(dia.id, servicioDetalle.id) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- CELDA 5: Pasajeros -->
                                <td class="px-4 py-3 border-r border-gray-300 min-w-[300px] max-w-[300px]">
                                    <div class="h-full">
                                        <AsignarPasajerosServicio 
                                            :pasajeros-disponibles="PasajerosReducido"
                                            v-model="servicioDetalle.pasajero_servicios.pasajerosAsignados"
                                            :servicio="servicioDetalle.pasajero_servicios"
                                            class="text-sm h-full"
                                        />
                                    </div>
                                </td>
                                
                                <!-- CELDA 6: Estado y Acciones -->
                                <td class="px-4 py-3 border-r border-gray-300 min-w-[300px] max-w-[300px]">
                                    <div class="space-y-3">
                                        <!-- Estado -->
                                        <div>
                                            <select v-model="servicioDetalle.pasajero_servicios.estatus"
                                                    class="w-full border rounded-lg px-3 py-2 text-sm font-medium transition-all focus:ring-2 focus:ring-opacity-50"
                                                    :class="{
                                                        'border-yellow-300 bg-yellow-50 text-yellow-800 focus:ring-yellow-500': servicioDetalle.pasajero_servicios.estatus == 0,
                                                        'border-green-300 bg-green-50 text-green-800 focus:ring-green-500': servicioDetalle.pasajero_servicios.estatus == 1,
                                                        'border-red-300 bg-red-50 text-red-800 focus:ring-red-500': [2,3].includes(servicioDetalle.pasajero_servicios.estatus)
                                                    }">
                                                <option value="0">🟡 PENDIENTE</option>
                                                <option value="1">✅ CONFIRMADA</option>
                                                <option value="2">❌ CANCELADA</option>
                                                <option value="3">👤 XPASAJERO</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Botones de Acción -->
                                        <div class="flex gap-2">
                                            <button type="button" 
                                                    @click="openModalStatus(dia.nro_dia, servicioDetalle.pasajero_servicios)"
                                                    class="flex-1 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs rounded-lg transition-colors flex items-center justify-center gap-1 border border-blue-200"
                                                    title="Editar estado">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span class="hidden sm:inline">Editar</span>
                                            </button>
                                            
                                            <button type="button" 
                                                    @click="agregarDetalle(dia.nro_dia, indexItinerario, dia.id)"
                                                    class="flex-1 px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-xs rounded-lg transition-colors flex items-center justify-center gap-1 border border-green-200"
                                                    title="Agregar detalle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span class="hidden sm:inline">Agregar</span>
                                            </button>
                                            
                                            <button type="button" 
                                                    @click="eliminarDetalle(dia.nro_dia, indexItinerario)"
                                                    class="flex-1 px-3 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-xs rounded-lg transition-colors flex items-center justify-center gap-1 border border-red-200"
                                                    title="Eliminar detalle">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span class="hidden sm:inline">Eliminar</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Transition>
        </div>
        </div>

        <!-- TARJETA 6: COSTOS -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-calculator text-green-500"></i>
                    Detalle de Costos
                </h3>
            </div>
            <div class="flex flex-col md:flex-row gap-4 w-full p-0 mb-4">
                <div class="w-full md:w-1/2">
                    <!-- <ServicioDetalle v-if="listaServicioDetalle.length > 0 || listaServicioDetalle.length != null"
                        :Lista_servicio_detalle = "listaServicioDetalle" 
                        :Lista_servicio_x_dia = "ListaServicioPasajeroTemp"
                        :Lista_Pasajeros = Cotizacion.pasajeros
                        v-model="contador"
                    /> -->
                </div>
                <div class="w-full md:w-1/2">
                    <div v-if="Object.keys(totalesPorMoneda).length > 0" class="overflow-x-auto">
                        <CotizacionTotales
                            :totalesPorMoneda="{ USD: totalesPorMoneda['USD'] ?? 0, PEN: totalesPorMoneda['PEN'] ?? 0 }"
                            :calcularTotalGeneral="calcularTotalGeneral"
                        />
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-10 gap-4 bm-4 pb-4 border-b border-gray-100">                
                <!-- Costo Parcial -->
                <div class="md:col-span-2">
                    <label for="costo_parcial" class="block text-sm font-medium text-gray-700 mb-1">
                        Costo Parcial
                    </label>
                    <input v-model="Cotizacion.costo_parcial" type="text" id="costo_parcial"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-right font-medium"
                           placeholder="0.00">
                </div>                
                
                <!-- Descuentos -->
                <div class="md:col-span-6">
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="descuento_estudiante" class="block text-sm font-medium text-gray-700 mb-1">
                                Desc. Estudiante
                            </label>
                            <input v-model="Cotizacion.descuento_estudiante"
                                   @input="(event) => handleInput(event, 'descuento_estudiante')" type="text"
                                   id="descuento_estudiante"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-right"
                                   placeholder="0.00">
                        </div>
                        
                        <div>
                            <label for="descuento_ninio" class="block text-sm font-medium text-gray-700 mb-1">
                                Desc. Niño
                            </label>
                            <input v-model="Cotizacion.descuento_ninio"
                                   @input="(event) => handleInput(event, 'descuento_ninio')" type="text"
                                   id="descuento_ninio"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-right"
                                   placeholder="0.00">
                        </div>
                        
                        <div>
                            <label for="descuento_otro" class="block text-sm font-medium text-gray-700 mb-1">
                                Otros Descuentos
                            </label>
                            <input v-model="Cotizacion.descuento_otro"
                                   @input="(event) => handleInput(event, 'descuento_otro')" type="text"
                                   id="descuento_otro"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-right"
                                   placeholder="0.00">
                        </div>
                    </div>
                </div>
                
                <!-- Costo Total -->
                <div class="md:col-span-2">
                    <label for="costo_total" class="block text-sm font-medium text-gray-700 mb-1">
                        Costo Total
                    </label>
                    <input v-model="Cotizacion.costo_total" type="text" id="costo_total"
                           class="w-full px-3 py-2 border-2 border-green-300 bg-green-50 rounded-lg text-right font-bold text-green-700"
                           placeholder="0.00" readonly>
                </div>
            </div>

            <div class="items-center mb-2 pt-4">
                <div class="flex justify-end">
                    <!-- Botón Submit -->
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 font-semibold text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                        {{ Accion || 'Guardar Cotización' }}
                    </button>
                    <button type="button" @click="mostrarConsola()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
    <PasajeroModal v-if="Cotizacion.pasajeros != null" :isModalVisible="showModal" :ListaPasajeros=Cotizacion.pasajeros
        :errorMessage="error" @close="showModal = false" @update=recalcularTotalPasajeros />
    <ClienteModal :isModalVisibleProveedor="showModalProveedor" :errorMessage="error"
        @close="showModalProveedor = false" @submit="recuperarValorModal" />
    <StatusModal 
        v-if ="showModalStatus"
        :id = "idServicioSeleccionado"
        :nroDia ="indiceStatusDia"
        :servicio="servicioSeleccionado"
        :mode="modalModeStatus"
        @cerrar=" showModalStatus = false"
        @guardar="updateServicio"     
    />

    <!-- Modal alojamiento -->
    <AlojamientoSelector

     v-if="modalAlojamiento.visible"
        :pasajeros=Cotizacion.nro_pasajeros
        :categoria=categoriaAlojamiento
        @preview="previsualizarAlojamiento"
        @confirm= "(seleccionado) => aplicarAlojamiento(seleccionado, modalAlojamiento.indexDia, modalAlojamiento.indexServicio)"
        @close="modalAlojamiento.visible = false"
        
    />

     <!-- v-if="modalAlojamiento.visible"
        :pasajeros=Cotizacion.nro_pasajeros
        :categoria=categoriaAlojamiento
        @update="aplicarAlojamiento"
        @close="modalAlojamiento.visible = false" -->
</template>

<script setup>
import { ref, watch, reactive, computed, onMounted, toRef } from 'vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import ContadorInput from '@/ComponentModal/ContadorInput.vue';
import PrimaryButton from '../PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Datepicker from '@/Components/Datepicker.vue'; // Importa el componente
import ServicioDetalle from '@/Components/ServicioDetalle/CompServicioDetalleAdd.vue';
import PasajeroModal from '@/Pages/Pasajero/CompModalPasajero.vue';
import ClienteModal from '@/Components/Proveedor/CompModalProveedor.vue';
import getCotizacionInicial from '@/models/cotizacionModel.js';
import getPersonaInicial from '@/models/personaModel.js';
import { useCategoriesStore } from '@/Stores/categories';
import { validateNumberInput } from '@/Utils/validators';
import calcularDiferenciaDias from '@/Utils/calculos';
import AsignarPasajerosServicio from '@/Components/AsignarPasajerosServicio.vue';
import InputHora from "@/Components/InputHora.vue";
import CotizacionTotales from '@/Components/Cotizacion/CompCotizacionTotales.vue';
//#region Computed Properties
import StatusModal from "@/Components/Cotizacion/CompModalStatus.vue";
import { generateFieldsFromObject } from '@/Utils/objectToFiels';
import { auditoriaSimple } from '@/Utils/JsonDiffDetector';

import HotelHabitacionManual from '@/Components/Cotizacion/CompHotelHabitacionManual.vue';
import AlojamientoSelector from '@/Components/Cotizacion/CompAlojamientoSelector.vue'

// resources/js/app.js o main.js
import '../../../css/excelTable.css';

const categoriesStore = useCategoriesStore();

// Definir las props
const props = defineProps({
    Accion: {
        type: String,
        required: true,
    },
    Cotizacion: {
        type: Object,
        required: true,
    },
    Lista_destinos_turistico: {
        type: Object,
        required: true,
    },
    // ListaCategorias: {
    //     type: Object,
    //     required: true,
    // },
    ListaServicios: {
        type: Object,
        required: true,
    },
});

// #region SELECCION DE HABITACIONES PARA SERVICIO
// Aquí guardaremos la distribución final que emite el hijo
const distribucionFinal = ref([])

function actualizarDistribucion(seleccion, indiceDia, indiceServicio) {
    distribucionFinal.value = seleccion

    const totalHabitaciones = seleccion.reduce(
        (sum, h) => sum + h.cantidad,
        0
    )

    const totalPasajeros = seleccion.reduce(
        (sum, h) => sum + h.capacidad * h.cantidad,
        0
    )

    // Subtotal del día
    const subtotal = seleccion.reduce(
        (sum, h) => sum + h.precio * h.cantidad,
        0
    )

  //serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].cantidad_pasajeros = totalPasajeros;
  serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.monto = subtotal;
  serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.cantidad_pasajeros = totalHabitaciones;
  serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.subtotal = subtotal;

    calcularSubtotal(indiceDia, indiceServicio);
}
//#endregion SELECCION DE HABITACIONES PARA SERVICIO

//#region SELECCION DE PROVEEDOR
const categoriaAlojamiento = ref(2)

const modalAlojamiento = ref({
  visible: false,
  indexDia: null,
  indexServicio: null
})

function editarAlojamiento(indexDia, indexServicio) {
  modalAlojamiento.value.visible = true
  modalAlojamiento.value.indexDia = indexDia
  modalAlojamiento.value.indexServicio = indexServicio
}

function previsualizarAlojamiento(resumen) {
  // opcional: mostrar precio en vivo
  console.log('opcion elegida previsualizar', resumen)
}

function aplicarAlojamiento(resumen, indiceDia, indiceServicio) {
    serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.monto = resumen.subtotal;
    serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.cantidad_pasajeros = resumen.totalHabitaciones;
    serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].pasajero_servicios.subtotal = resumen.subtotal;
    serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].catalogoHabitaciones = resumen.habitaciones;
    serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio].servicio.proveedor.razon_social = resumen.proveedor.razon_social;

    console.log('opcion elegida', resumen);
    calcularSubtotal(indiceDia, indiceServicio);

    modalAlojamiento.value.visible = false
}
//#endregion SELECCION DE PROVEEDOR

const esEdicion = computed(() => props.Accion === 'edit');

// const esHoraValida = ref(true);

const sTipoComprobante = ref([...categoriesStore.globals.tipo_comprobantes]);
const sPais = ref([...categoriesStore.globals.pais]);
const sIdioma = ref([...categoriesStore.globals.idioma]);
const sMercado = ref([...categoriesStore.globals.mercado]);
const sCategoriaProveedor = ref([...categoriesStore.globals.proveedor_categories]);

const servicios = ref([...props.ListaServicios]);


const axiosServicios = async () => {
    try {
        const response = await axios.post(`${route('servicio')}/servicioList`, { proveedor_id: null });
        servicios.value = response.data
    } catch (error) {
        console.error('Error al recuperar usuarios:', error)
    }
}

const serviciosPorDia = ref([])

const toggleTable = (index) => {
    serviciosPorDia.value[index].isVisible = !serviciosPorDia.value[index].isVisible;
}

onMounted(() => {
   // cargarProveedores();
})

// Variables reactivas
const error = ref('');
const ultimaAccion = ref('');
const showModal = ref(false);
const showModalProveedor = ref(false);
const DestinoTuristico = props.Lista_destinos_turistico
//const sCategoriaProveedor = props.ListaCategorias
const fechaActual = ref(new Date());
const ListaServicioPasajeroTemp = reactive([]);
const listaServicioDetalle = ref([]);

const EstadoCotizacion = ref([
    { value: '0', label: 'PENDIENTE' },
    { value: '1', label: 'CONFIRMADA' },
    { value: '2', label: 'CANCELADA' },
]);

// Timer para controlar el delay
let emptyInputTimeout = null;

// Variables para el cotizacion y detalle temporal
//const Cotizacion = reactive(getCotizacionInicial());
const Cotizacion = reactive(props.Cotizacion); // || reactive(getCotizacionInicial());
const cotizacionOriginal = ref(null);

// Cotizacion.file_nro = props.Correlativo;
Cotizacion.fecha = esEdicion.value ? new Date(Cotizacion.fecha) : fechaActual.value;
Cotizacion.fecha_inicio = esEdicion.value ? new Date(Cotizacion.fecha_inicio) : fechaActual.value;
Cotizacion.fecha_fin = esEdicion.value ? new Date(Cotizacion.fecha_fin) : fechaActual.value;

const pasajero = ref(getPersonaInicial());

const errorFecha = ref("");
const PasajerosReducido = computed(() =>
    Cotizacion.pasajeros.map(p => ({
        get id() { return p.id },
        set id(val) { p.id = val },
        get temp_id() { return p.temp_id },
        set temp_id(val) { p.temp_id = val },
        get nombre() { return p.nombre },
        set nombre(val) { p.nombre = val },
        get tipo_pasajero_id() { return p.tipo_pasajero_id },
        set tipo_pasajero_id(val) { p.tipo_pasajero_id = val },
    }))
)

if (esEdicion.value) {   
    serviciosPorDia.value = Cotizacion.pasajeros_servicios_agrupados;
    console.log('serviciosPorDia.value desde edicion', serviciosPorDia.value);
    // snapshot profundo (NO reactivo)
    cotizacionOriginal.value = { ...Cotizacion };

    serviciosPorDia.value.forEach(dia => {
        dia.isVisible = true; // Inicialmente todas las tablas visibles
        serviciosPorDia.value.forEach(dia => {
            dia.isVisible = true;

            const catalogoHabitaciones0 = [];

            dia.itinerario_servicios.forEach(itinerarioServicio => {
                const listaPrecios = itinerarioServicio.servicio?.precios;

                if (!listaPrecios) return;
                
                listaPrecios.forEach(precio => {
                    if (precio.tipo_costo !== 'HABITACION') return;
                    catalogoHabitaciones0.push({
                        id: precio.id,
                        nombre: itinerarioServicio.servicio?.servicio_detalles?.descripcion ?? '',
                        tipo: precio.tipo_habitacion,
                        capacidad: precio.capacidad_pax,
                        precio: Number(precio.monto),
                        moneda: precio.moneda
                    });
                });
            });

            dia.itinerario_servicios.forEach(servicio => {
                servicio.catalogoHabitaciones = [...catalogoHabitaciones0];
            });
        });
    });
    //console.log('serviciosPorDia.value edit', serviciosPorDia.value);
    listaServicioDetalle.value = calcularMontoTotalXCategoria(Cotizacion.destinos_turisticos);
    agregarServicioPasajeroTemp();
    //calcularVenta();
}


// Observa cambios en `nro_pasajeros` y ejecuta `calcularVenta`
watch(() => Cotizacion.nro_pasajeros, (newNroPasajeros) => {
    agregarServicioPasajeroTemp();
    calcularVenta();
});

const showInput = ref(false)
const newItem = ref('')


function handleChange(indiceDia, indiceServicio) {
    const servicioDetalle = serviciosPorDia.value[indiceDia - 1].itinerario_servicios[indiceServicio];
    if (servicioDetalle.servicio_id == '__add_new__') {
        showInput.value = true
        servicioDetalle.servicio_id = '0'
    }
}

function addItem() {
    if (newItem.value.trim()) {
        items.value.push(newItem.value.trim())
        newItem.value = ''
        showInput.value = false
    }
}


function agregarServicioPasajeroTemp() {
    const nuevaLista = Cotizacion.destinos_turisticos.itinerario_destinos.map(servicio => {
        return {
            nro_dia: servicio.nro_dia,
            itinerario_destinos: PasajerosReducido.value.map(pasajero => ({
                pasajero,
                servicio: '',
                itinerario_servicios: [...servicio.itinerario_servicios]
            }))
        };
    });


    ListaServicioPasajeroTemp.splice(0, ListaServicioPasajeroTemp.length, ...nuevaLista);

    Cotizacion.destino_turistico_detalle = serviciosPorDia.value; // ListaServicioPasajeroTemp;
}

async function recuperarValorModal(persona) {
    showModalProveedor.value = false;
    Cotizacion.proveedor_id = persona.id;
    Cotizacion.proveedor_razon_social = persona.razon_social;
    const nroDoc = document.getElementById('cliente_nro_doc');
    nroDoc.value = persona.ruc;
    Cotizacion.cliente_nro_doc = persona.ruc;
}

//#region SECCION CALCULAR SUBTOTAL Y TOTAL DE LA NUEVA LOGICA DE SERVICIOS POR DIA

// Métodos para manejar montos (igual que antes)
const handleMontoInput = (event, diaId, servicioId) => {
    const dia = serviciosPorDia.value.find(d => d.id === diaId)
    const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)

    if (servicio) {
        let value = event.target.value.replace(/[^0-9.]/g, '')
        const parts = value.split('.')
        if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('')
        if (parts.length === 2) value = parts[0] + '.' + parts[1].slice(0, 2)

        servicio.pasajero_servicios.monto = value
        calcularSubtotal(diaId, servicioId)
    }
}

const formatMonto = (diaId, servicioId) => {
    const dia = serviciosPorDia.value.find(d => d.id === diaId)
    const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)

    if (servicio) {
        let monto = parseFloat(servicio.pasajero_servicios.monto) || 0
        servicio.pasajero_servicios.monto = monto.toFixed(2)
        calcularSubtotal(diaId, servicioId)
    }
}

// Calcular subtotal cuando cambia monto o cantidad
const calcularSubtotal = (diaId, servicioId) => {
    const dia = serviciosPorDia.value.find(d => d.id === diaId)
    const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)

    if (servicio) {
        const monto = parseFloat(servicio.pasajero_servicios.monto) || 0
        const cantidad = servicio.pasajero_servicios.cantidad_pasajeros || 1
        servicio.pasajero_servicios.subtotal = monto * cantidad
    }
}

// Mostrar subtotal formateado
const calcularSubtotalDisplay = (diaId, servicioId) => {
    const dia = serviciosPorDia.value.find(d => d.id === diaId)
    const servicio = dia?.itinerario_servicios.find(s => s.id === servicioId)
    return servicio ? (servicio.pasajero_servicios.subtotal || 0).toFixed(2) : '0.00'
}

// Computed: Totales por moneda (ahora usa subtotal)
const totalesPorMoneda = computed(() => {
    const resultado = {}

    serviciosPorDia.value.forEach(dia => {
        dia.itinerario_servicios.forEach(servicio => {
            const moneda = servicio.pasajero_servicios.moneda
            const subtotal = parseFloat(servicio.pasajero_servicios.subtotal) || 0

            resultado[moneda] = (resultado[moneda] || 0) + subtotal
        })
    })

    return resultado
})

// Computed: Total general (suma de todos los subtotales)
const calcularTotalGeneral = computed(() => {
    return Object.values(totalesPorMoneda.value).reduce((sum, total) => sum + total, 0)
})

// #endregion SECCION CALCULAR SUBTOTAL Y TOTAL DE LA NUEVA LOGICA DE SERVICIOS POR DIA

// #region SECCION DE MANIPULACION DE STATUS
const modalModeStatus = ref('create'); // 'create' o 'edit'
const showModalStatus = ref(false);
const idServicioSeleccionado = ref(0);
const servicioSeleccionado = ref(null);
const indiceStatusDia = ref(0);

const openModalStatus = (indexDia, servicio) => {

    idServicioSeleccionado.value = `${indexDia}${servicio.nro_orden}`;
    servicioSeleccionado.value = servicio;
    indiceStatusDia.value = indexDia;
    modalModeStatus.value = props.Accion;
    showModalStatus.value = true;
};

function updateServicio(newServicio) {    
    showModalStatus.value = false;
}

// #endregion SECCION DE MANIPULACION DE STATUS

function agregarDetalle(indiceItinerario, indiceServicio, itinerarioDestinoId = null) {
    const nuevoServicio = {
        id: crypto.randomUUID().replace(/-/g, '').substring(0, 8),
        nro_orden: '',
        servicio_id: '0',
        itinerario_destino_id: '0',
        proveedor_categoria_id: '0',
        proveedor_id: '0',
        servicio: {
            id: '',
            proveedor_id: '0',
            servicio_detalle_id: '0',
            ubicacion_id: '0',
            estado_activo: '1',
            precios: []
        },
        pasajero_servicios: {
            id: null,
            cotizacion_id: Cotizacion.id,
            itinerario_servicio_id: '',
            itinerario_destino_id: itinerarioDestinoId,
            hora: '21:00',
            pasajerosAsignados: [],
            observacion: '',
            moneda: 'USD',
            monto: 0,
            cantidad_pasajeros: 1,
            subtotal: 0,
            estatus: '0', // PENDIENTE
            estado_activo: '1'
        }
    };
    // Agregar el nuevo servicio al último día de serviciosPorDia
    if (serviciosPorDia.value.length > 0) {
        serviciosPorDia.value[Number(indiceItinerario) - 1].itinerario_servicios.splice(Number(indiceServicio) + 1, 0, nuevoServicio);
    } else {
        // Si no hay días, crear uno nuevo  
        serviciosPorDia.value.push({
            nro_dia: 1,
            itinerario_id: '',
            nombre: '',
            observacion: '',
            estado_activo: 1,
            destino_turistico_id: '',
            itinerario_servicios: [nuevoServicio]
        });
    }
}

function eliminarDetalle(indiceItinerario, indiceServicio) {
    serviciosPorDia.value[Number(indiceItinerario) - 1].itinerario_servicios.splice(Number(indiceServicio), 1);    
}

function eliminarItinerario(indiceItinerario) {
    serviciosPorDia.value.splice(Number(indiceItinerario), 1);
}

async function ListaCategoriaProveedor() {
    try {
        const response = await axios.post(`${route('destino_turistico')}/destinoServicios`, { destino_turistico_id: Cotizacion.destino_turistico_id });
        if (response.status === 200) {
            const servicioAxios = response.data.itinerario_destinos.map(dia => {

                // 1) Construimos el catálogo completo del día
                const catalogoHabitaciones0 = [];

                dia.itinerario_servicios.forEach(itinerarioServicios => {
                    const listaPrecios = itinerarioServicios.servicio?.precios ?? [];

                    listaPrecios.forEach(precio => {
                        if (precio.tipo_costo !== 'HABITACION') return;

                        catalogoHabitaciones0.push({
                            id: precio.id,
                            nombre: itinerarioServicios.servicio?.servicio_detalles?.descripcion ?? '',
                            tipo: precio.tipo_habitacion,
                            capacidad: precio.capacidad_pax,
                            precio: Number(precio.monto),
                            moneda: precio.moneda
                        });
                    });
                });

                // 2) Ahora sí, devolvemos cada servicio con el catálogo completo
                return {
                    ...dia,
                    isVisible: true,

                    itinerario_servicios: dia.itinerario_servicios.map(itinerarioServicios => {

                        const precio = itinerarioServicios.servicio?.precios?.[0] ?? {};

                        return {
                            ...itinerarioServicios,

                            pasajero_servicios: {
                                id: null,
                                cotizacion_id: Cotizacion.id,
                                itinerario_servicio_id: itinerarioServicios.id,
                                itinerario_destino_id: dia.id,
                                hora: '09:00',
                                pasajerosAsignados: [],
                                observacion: '',
                                moneda: precio.moneda ?? 'USD',
                                monto: precio.monto ?? 0,
                                cantidad_pasajeros: 1,
                                subtotal: (precio.monto ?? 0) * 1,
                                estatus: '0',
                                estado_activo: '1'
                            },

                            // Catálogo completo para todos los servicios del día
                            catalogoHabitaciones: [...catalogoHabitaciones0]
                        };
                    })
                };
            });

            console.log('serviciosPorDia.value desde destino', servicioAxios);


            serviciosPorDia.value = reactive(servicioAxios);

            Cotizacion.nro_dias = response.data.nro_dias;
            const fechaInicio = new Date(Cotizacion.fecha_inicio);
            fechaInicio.setDate(fechaInicio.getDate() + response.data.nro_dias);
            const fechaFina = new Date(fechaInicio);
            Cotizacion.fecha_fin = fechaFina;

            listaServicioDetalle.value = calcularMontoTotalXCategoria(response.data);
            Cotizacion.destinos_turisticos.itinerario_destinos = response.data.itinerario_destinos;
            agregarServicioPasajeroTemp();
            calcularVenta();
        }
    } catch (error) {
        console.error('Error al actualizar los datos:', error);
    }
};

function calcularMontoTotalXCategoria(destino) {
    const resultado = {};
    destino.itinerario_destinos.forEach(detalle => {
        detalle.itinerario_servicios.forEach(servicio => {
            const categoriaId = servicio.proveedor_categoria_id;
            const monto = parseFloat(servicio.monto) || 0;

            if (!resultado[categoriaId]) {
                resultado[categoriaId] = {
                    categoria: categoriaId,
                    total_monto: 0,
                    cantidad: 0
                };
            }
            resultado[categoriaId].total_monto += monto;
            resultado[categoriaId].cantidad += 1;
        });
    });
    return Object.values(resultado);
}

// #region SECCION DE MANIPULACION DE FECHAS

// **Validar que fecha_inicio nunca sea mayor a fecha_fin**
watch([() => Cotizacion.fecha_inicio, () => Cotizacion.fecha_fin], ([inicio, fin]) => {
    if (new Date(inicio) > new Date(fin)) {
        errorFecha.value = "La fecha de inicio no puede ser mayor que la fecha fin.";
    } else {
        errorFecha.value = "";
    }
    Cotizacion.nro_dias = calcularDiferenciaDias(Cotizacion.fecha_inicio, Cotizacion.fecha_fin);
});

function manejarCambioFecha(fechaInicio) {
    //alert(`Seleccionaste: ${fechaInicio.toLocaleDateString('es-ES')}`)
    const nuevaFechaFin = new Date(fechaInicio)
    nuevaFechaFin.setDate(nuevaFechaFin.getDate() + Cotizacion.nro_dias - 1); // Restamos 1 porque la fecha de inicio cuenta como el primer día
    Cotizacion.fecha_fin = nuevaFechaFin
}
// #endregion SECCION DE MANIPULACION DE FECHAS

// #region SECCION INCREMENTO Y DECREMENTO DE PASAJEROS
const handleInput = (event, field) => {
    const validatedValue = validateNumberInput(event.target.value);
    Cotizacion[field] = Number(validatedValue);

    // Limpiar cualquier temporizador existente
    if (emptyInputTimeout) {
        clearTimeout(emptyInputTimeout);
    }

    // Si el input está vacío, esperar 1 segundo antes de asignar "0"
    if (!validatedValue) {
        emptyInputTimeout = setTimeout(() => {
            Cotizacion[field] = 0;
            calcularVenta(validatedValue);
        }, 1000); // 1000 ms = 1 segundo
    } else {
        // Calcular venta si el valor es válido
        calcularVenta(validatedValue);
    }
};

const tipoPasajeroPorId = {
    nro_ninio: '1',
    nro_estudiante: '2',
    nro_adulto: '3'
};

const manejarAccion = ({ accion, id }) => {
    ultimaAccion.value = { accion, id };

    const tipo_pasajero = tipoPasajeroPorId[id];
    if (!tipo_pasajero) return;

    (accion === 'incremento' ? agregarPasajero : eliminarPasajero)(tipo_pasajero);
};

const recalcularTotalPasajeros = () => {
    Cotizacion.nro_ninio = contarPasajerosPorTipo('1');
    Cotizacion.nro_estudiante = contarPasajerosPorTipo('2');
    Cotizacion.nro_adulto = contarPasajerosPorTipo('3');
};

const contarPasajerosPorTipo = (tipo) => {
    return Cotizacion.pasajeros.filter((pasajero) => pasajero.tipo_pasajero_id === tipo).length || 0;
};

// Observar cambios en los valores de adultos, niños y bebés
watch([() => Cotizacion.nro_adulto, () => Cotizacion.nro_ninio, () => Cotizacion.nro_estudiante], ([new_nro_adulto, new_nro_ninio, new_nro_estudiante]) => {
    Cotizacion.nro_pasajeros = new_nro_adulto + new_nro_ninio + new_nro_estudiante;
}, { immediate: true });

// Computed reactivo para que cambie cuando cotizacion.nro_pasajeros cambie
const contador = computed(() => Cotizacion.nro_pasajeros);

function agregarPasajero(tipoPasajero) {
    const nuevo = getPersonaInicial();
    nuevo.tipo_pasajero_id = tipoPasajero;
    nuevo.id = Cotizacion.pasajeros.length + 1;
    Cotizacion.pasajeros.push(nuevo);
}

const eliminarPasajero = (tipoPasajero) => {
    const index = Cotizacion.pasajeros.findIndex(
        (pasajero) => pasajero.tipo_pasajero_id === tipoPasajero
    );
    if (index >= 0) {
        Cotizacion.pasajeros.splice(index, 1);
    }
}

// #endregion SECCION INCREMENTO Y DECREMENTO DE PASAJEROS

const mostrarConsola = () => {
    console.log(Cotizacion);
    const jsonData = JSON.stringify(Cotizacion, null, 2);
    console.log("JSON Data:", jsonData);

    let cambios = auditoriaSimple(cotizacionOriginal.value, Cotizacion);
    console.log('cambios', cambios);
}

// Función para calcular el monto de la venta
const calcularVenta = () => {
    const sumaTotal = listaServicioDetalle.value.reduce((acc, item) => acc + (item.total_monto * Cotizacion.nro_pasajeros), 0);
    const sumaDescuentos = Number(Cotizacion.descuento_estudiante) + Number(Cotizacion.descuento_ninio) + Number(Cotizacion.descuento_otro);
    Cotizacion.costo_parcial = sumaTotal;
    Cotizacion.costo_total = sumaTotal - sumaDescuentos;
};

function agregarDetalleDatosPasajero() {
    showModal.value = true;
}

async function submitCotizacion() {
    try {
        Swal.fire({
            title: 'Cargando...',
            text: 'Por favor, espera mientras se cargan los datos.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        Cotizacion.destino_turistico_detalle_monto_x_categoria = listaServicioDetalle.value;
        const response = await axios.post(route('cotizacion.store'), Cotizacion, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        Swal.close();

        if (response.status === 200) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.data.message,
                confirmButtonText: 'Aceptar',
            }).then(() => {
                window.location.href = route('cotizacion'); // Redirige después de cerrar el modal.
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Error al agregar el elemento. ${response.data.message}`,
                confirmButtonText: 'Aceptar',
            });
        }
    } catch (err) {
        console.error('Error al registrar el cotizacion:', err);
        const errorMessage = err.response?.data?.message || 'Ocurrió un error inesperado';
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage,
            confirmButtonText: 'Aceptar',
        });

        // Asigna el mensaje de error a la variable "error" si es necesario.
        error.value = errorMessage;
    }
}
</script>

<style scoped>
/*efecto de transición para la tabla */
.fade-slide-enter-active, .fade-slide-leave-active {
    transition: all 0.5s ease;
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(-10px);
}
.fade-slide-enter-to {
    opacity: 1;
    transform: translateY(0);
}
.fade-slide-leave-from {
    opacity: 1;
    transform: translateY(0);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>

