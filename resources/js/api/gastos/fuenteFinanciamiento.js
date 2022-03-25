import auth from '../auth'
import hash from '@/js/api/hash'

export default {
  requestFuenteFinanciamiento () {
    return axios.get('/app/presupuesto/fuenteFinanciamiento')
  },
  saved () {
    hash.verificarHash('fuenteFinanciamiento', this.destroyfuenteFinanciamiento)
    return !!localStorage.getItem('fuenteFinanciamiento')
  },
  save (fuenteFinanciamiento) {
    localStorage.setItem('fuenteFinanciamiento', JSON.stringify(fuenteFinanciamiento))
  },
  getfuenteFinanciamiento () {
    return JSON.parse(localStorage.getItem('fuenteFinanciamiento'))
  },
  destroyfuenteFinanciamiento () {
    localStorage.removeItem('fuenteFinanciamiento')
  },
  iniciales (str) {
    let words = str.split(' ')
    let iniciales = ''
    let excludeWords = ['___', 'POR', 'DE', 'EN', 'Y']
    for (let i = 0; i < words.length; i++)
      if (words.length > 1)
        if (excludeWords.indexOf(words[i]) === -1)
          iniciales += words[i].substring(0, 1)
    return iniciales
  },
}
