module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/recommended',
    'eslint:recommended',
    'airbnb/base',
    '@vue/typescript/recommended',
  ],
  plugins: [
    'typescript',
    'import',
    'vue',
  ],
  parserOptions: {
    ecmaVersion: 2020,
  },
  globals: {
    config: "readable",
  },
  validate: [
    "javascript",
    "javascriptreact",
    "vue",
  ],
  rules: {
    'no-console': 'off',
    'eol-last': 'off',
    '@typescript-eslint/no-explicit-any': 'off',
    'import/no-unresolved': 'off',
    'no-param-reassign': 'off',
    'import/extensions': 'off',
    'no-shadow': 'off',
    "no-unused-vars": "off",
    'no-new': 'off',
    'import/prefer-default-export': 'off',
    'no-underscore-dangle': 'off',
    'no-restricted-globals': 'off',
    'no-restricted-syntax': 'off',
    '@typescript-eslint/camelcase': 'off',
    'no-undef': 'off',
    'vue/max-attributes-per-line': [
      1,
      {
        singleline: 1,
        multiline: {
          max: 1,
          allowFirstLine: false,
        },
      },
    ],
  },
  overrides: [
    {
      files: [
        '**/__tests__/*.{j,t}s?(x)',
        '**/tests/unit/**/*.spec.{j,t}s?(x)',
      ],
      env: {
        mocha: true,
      },
    },
  ],
};
