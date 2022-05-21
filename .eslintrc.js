/* eslint-env node */
require("@rushstack/eslint-patch/modern-module-resolution")


module.exports = {
  root: true,
  env: {
    browser: true,
    es2021: true,
    node: true,
  },
  extends: [
    // 'plugin:prettier/recommended',
    "plugin:vue/vue3-recommended",
    "eslint:recommended",
    "@vue/typescript/recommended",
      "@vue/prettier",
    // "@vue/prettier/@typescript-eslint"
  ],
  rules: {
    'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
    '@typescript-eslint/ban-ts-comment': 'off',
    "@typescript-eslint/ban-ts-ignore": "off",
    '@typescript-eslint/no-explicit-any': 'off',
    '@typescript-eslint/no-empty-interface': 'off',
    '@typescript-eslint/explicit-module-boundary-types': 'off',
    '@typescript-eslint/no-non-null-assertion': 'off',
    'vue/require-default-prop': 'off',
    'vue/no-v-html': 'off',
    'no-undef': 'off',
  },
}
