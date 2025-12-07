<template>
  <table class="excel-table w-full text-sm text-left text-gray-500">
    <!-- <thead class="text-sm text-gray-900 uppercase bg-gray-50">
      <tr class="bg-gray-100">
        <th class="w-8/12 px-4 py-2">Total</th>
        <th class="w-2/12 px-4 py-2 text-center">PEN</th>
        <th class="w-2/12 px-4 py-2 text-center">USD</th>
      </tr>
    </thead> -->
    <tbody>
      <!-- Total por moneda -->
      <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 mx-2 text-sm">Total por moneda</td>        
        <td class="px-4 text-right">
          <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalPEN.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-blue-500">PEN</span>
          </div>
        </td>
        <td class="px-4 text-right">
          <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalUSD.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
        </td>
      </tr>
      <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 mx-2 text-sm">Total PEN en USD por tipo de cambio (PEN/TC)</td>        
        <td class="px-4 text-right">
          <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalPEN.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-blue-500">PEN</span>
          </div>
        </td>
        <td class="px-4 text-right">
          <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalPENenUSD.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
        </td>
      </tr>

      <!-- Total gastos fijos -->
      <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 mx-2 text-sm">TOTAL GASTOS FIJOS</td>
        <td class="px-4"></td>
        <td class="px-4 text-right">
          <div class="relative">
            <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalGastosFijos.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
          </div>
        </td>
      </tr>

      <!-- Total a ganar -->
      <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 text-sm">TOTAL A GANAR</td>
        <td class="px-4"></td>
        <td class="px-4 text-right">
          <div class="relative">
            <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalAGanar.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
          </div>
        </td>
      </tr>

      <!-- Impuesto a la renta -->
      <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 ml-2 text-sm">
          Impuesto a la Renta Mensual / Anual SUNAT
        </td>
        <td class="px-4"></td>
        <td class="px-4 text-right border-b text-black">
          <div class="relative">
            <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalImpuestoRenta.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
          </div>
        </td>
      </tr>
      <!-- Total a cobrar por grupo -->
       <tr class="bg-white border-b text-gray-900 font-semibold">
        <td class="px-4 ml-2 text-sm">
          TOTAL A COBRAR POR GRUPO
        </td>
        <td class="px-4"></td>
        <td class="px-4 text-right border-b text-black">
          <div class="relative">
            <div class="relative">
            <h3 class="w-full pr-2 text-black font-bold text-xs text-right">{{ totalACobrarPorGrupo.toFixed(2) }}</h3>
            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-xs text-right text-green-500">USD</span>
          </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { computed } from "vue";

// Props para recibir datos desde el padre
const props = defineProps({
  totalesPorMoneda: {
    type: Object,
    default: () => ({ USD: 0, PEN: 0 }),
  },
  calcularTotalGeneral: {
    type: Number,
    default: 0,
  },
});

const totalPEN = computed(() => {
  return props.totalesPorMoneda.PEN;
});

const totalUSD = computed(() => {
  return props.totalesPorMoneda.USD;
});
const totalPENenUSD = computed(() => {
  const tipoCambio = 3.7; // Ejemplo de tipo de cambio
  return (props.totalesPorMoneda.PEN / tipoCambio);
});
const totalGastosFijos = computed(() => {
  return totalUSD.value + totalPENenUSD.value;
});

const totalAGanar = computed(() => {
  const cteGanancia = 0.2; // 20% de ganancia
  return (props.calcularTotalGeneral * cteGanancia);
});

const totalImpuestoRenta = computed(() => {
  const cteImpuesto = 0.19; // 19% de impuesto
  return (props.calcularTotalGeneral * cteImpuesto);
});

const totalACobrarPorGrupo = computed(() => {
  return totalGastosFijos.value + totalAGanar.value + totalImpuestoRenta.value;
});
</script>
