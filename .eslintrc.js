  module.exports = {
  extends: [
    // add more generic rulesets here, such as:
    // 'eslint:recommended',
    'plugin:vue/recommended'],
  rules  : {
    // override/add rules settings here, such as:
    // 'vue/no-unused-vars': 'error'
    'vue/max-attributes-per-line'                : [
      'error', {
        'singleline': 10,
        'multiline' : {
          'max'           : 1,
          'allowFirstLine': false
        }
      }],
    'vue/no-side-effects-in-computed-properties' : 'off',
    'vue/singleline-html-element-content-newline': 'off',
    'vue/multiline-html-element-content-newline' : 'off',
    'vue/html-self-closing'                      : [
      'error', {
        'html': {
          'void'     : 'always',
          'normal'   : 'never',
          'component': 'always'
        },
        'svg' : 'always',
        'math': 'always'
      }]
  }
}
