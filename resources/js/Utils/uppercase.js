// uppercase.js
export default {
  beforeMount(el) {
    el.addEventListener('input', () => {
      el.value = el.value.toUpperCase()
      el.dispatchEvent(new Event('input'))
    })
  }
}