## Before release
1. Make sure Node modules required for development are removed. So, do not package the plugin without removing those.
The development packages can be removed by running `npm prune --production` in `app/public` directory.
2. Clear `app/storage/cache` directory.

## After release
1. Make sure Node modules required for development are added.
The development packages can be added by running `npm install` in `app/public` directory.

## About TypeScript Modules
- Configurations common to both dev and production environments are in `app/public/webpack.common.js`
- Production configuration file is `app/public/webpack.prod.js`
- Development configuration file is `app/public/webpack.dev.js`

### Compiling modules written in TypeScript
First, install Node dependencies declared in `app/public/package.json`. Then

1. cd into `public` directory: `cd app/public`
2. Run `npx webpack --config webpack.dev.js` for development, `npx webpack --config webpack.prod.js` for production.
3. See `app/public/webpack.common.js` to know where the compiled files are stored.

### Declaring new TypeScript modules
1. Go to `app/public/webpack.common.js`
2. Declare new module.
3. To compile, run `npx webpack --config webpack.dev.js` for development, `npx webpack --config webpack.prod.js` for production.

### Loading development versions of assets while being in production
This can be done in two ways:
- Passing 'debug' as URL parameter. E.g. `/resource/path/?debug`
- Changing the value of Constants::ENV to `dev`