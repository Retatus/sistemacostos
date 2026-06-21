// uppercase.js
export default {
  beforeMount(el) {
    el.addEventListener('input', (e) => {
      const start = el.selectionStart;
      const end = el.selectionEnd;

      el.value = e.target.value.toUpperCase();

      // restaurar posición del cursor
      el.setSelectionRange(start, end);
    });
  }
};