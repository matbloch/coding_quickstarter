# Webpack
- **Version:** 4
- **Prerequisites**: Install Node.js and NPM

[TOC]

## Project Setup

**Installation**
1. `npm init` in static folder (creates npm package configuration file `package.json`)
2. Install **Webpack** bundler (as dev-dependency)
    - `npm i webpack --save-dev`
    - `npm i webpack-cli --save-dev` Command Line Interface

**Project Structure**

```bash
.
├── README.md
└── fullstack_template/
    ├── node_modules
    ├── dist/
    ├── images/
    └── src/
        └── components/
        index.js
    webpack.config.js
    package.json
```

#### NPM Package Configuration: `package.json`
- `package.json`: Node package configuration
	- Tracks all dependencies and versions (packages installed through `npm i {PACKAGENAME} --save/--save-dev`)
	- Automates dependency installation through `npm`
	- Orchestrate multiple scripts with `npm start` by defining different tasks (e.g. builds or server start)

**Package Description**
```json
{
  "name": "react_boilerplate",
  "version": "0.1.0",
  "private": true,
  "description": ""
}
```

#### Webpack Configuration: `webpack.config.js`

1. Create config file `webpack.config.js` with content:
```javascript
const webpack = require('webpack');
const path = require('path');
const config = {
	// entrypoint to bundle all ressources
	entry: [
		__dirname + '/src/index.js'
	],
	// generate bundle file that is served by the app
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'app.bundle.js',
    },
    // automatically resolve these extensions (no extensions needed during import)
    resolve: {
        extensions: ['.js', '.jsx', '.css']
    },
};
module.exports = config;
```


2. Add Webpack build tasks to node.js `package.json`
```javascript
...
"scripts": {
    "build": "webpack -p --progress --config webpack.config.js",
    "dev-build": "webpack --progress -d --config webpack.config.js",
    "test": "echo \"Error: no test specified\" && exit 1",
    "watch": "webpack --progress -d --config webpack.config.js --watch"
},
...
```


## Webpack Dev Server
- Small in-memory server that serves the `/dist` folder
- instead of typing `npm run build` everytime a file has changed, the dev server will automatically refresh file upon modification


**Installation**
- `npm install webpack-dev-server --save-dev`

**Configuration**
- Specify serving folder, host and port in `webpack.config.js`
    ```javascript
    const config = {
        ...
        devServer: {
            // folder to serve the app from
            contentBase: path.join(__dirname, 'dist'),
            inline: true,
            host: process.env.HOST, // Defaults to `localhost`
            port: process.env.PORT, // Defaults to 8080
            compress: true,
        },
        ...
    }
    ```
- Add server to `package.json` scripts (with `start` key) to simplify startup:
```json
"scripts": {
  "start": "webpack-dev-server --mode development",
  ...
}
```
- Type `npm run` to start the server


## Bundling Addons

#### 0. Composing Configuration
- Split up individual parts of the configuration in separate files
- Merge them into an array using `webpack-merge`

**Installation**
- `npm install webpack-merge --save-dev`

**Example:**
`webpack.parts.js`
```javascript
exports.devServer = ({ host, port } = {}) => ({
  devServer: {
    stats: "errors-only",
    host, // Defaults to `localhost`
    port, // Defaults to 8080
    open: true,
    overlay: true,
  },
});
```
`webpack.config.js`
```javascript
const merge = require("webpack-merge");
const parts = require("./webpack.parts");

const commonConfig = merge([
  {
    ...
  },
]);

// PRODUCTION CONFIGURATION
const productionConfig = merge([]);

// DEVELOPOMENT CONFIGURATION
const developmentConfig = merge([
  parts.devServer({
    // Customize host/port here if needed
    host: process.env.HOST,
    port: process.env.PORT,
  }),
]);

module.exports = mode => {
  if (mode === "production") {
    return merge(commonConfig, productionConfig, { mode });
  }
  return merge(commonConfig, developmentConfig, { mode });
};
```


#### A. React
- Transpile EC6 into EC5 (through babel)
- Transpile ReactJS (through babel)

**Installation**
1. Install **React.js** (as dependency)
	- `npm install react --save`
	- `npm install react-dom --save`
2. Install **Babel** transpiler and plugins (as dev-dependency)
	- **babel-core**`npm install babel-core --save-dev` Transforms ES6 code into ES5
	- **babel-loader** `npm install babel-loader --save-dev` Webpack helper to integrate Babel
	- **babel-preset-env** `npm install babel-preset-env --save-dev` Determines which transformations & plugins to transpile code for browser matrix you want to support
	- **babel-preset-react** `npm install babel-preset-react --save-dev` Preset for all react plugins (e.g. turning JSX into functions)

**webpack.config.js**

```javascript
const config = {
	...
	module: {
	  // modules to transform other languages to js
      rules: [
         {
			// pipe every file with this extension through babel-loader
            test: /\.jsx?$/,
            exclude: /node_modules/,
			// webpack babel loader
		    use: {
				loader: 'babel-loader',
				options: { 
					presets: ['env', 'react']
				}
		    }
         },
      ]
   },
   ...
};
```


#### B. React Hot Reloading
- Automatically reload part of React.JS code that has changed

**Installation**
1. `npm i react-hot-loader --save-dev`

**webpack.config.js**
```javascript
const config = {
    ...
    // add the plugin here
    plugins: [
		new webpack.HotModuleReplacementPlugin()
	],
    ...
}
```

**Enabling the Plugin**
- Add `module.hot.accept();` after ReactDOM rendering
```javascript
ReactDOM.render(<App />, document.getElementById('app'));
if (module.hot) {
	module.hot.accept();
}
```


#### C. CSS/SCSS

- `css-loader`: Resolves `@import` and `url()` statements in css code
- `style-loader`: Adds CSS to the DOM by injecting a `<style>` tag
- `scss-loader`: Preprocessor for scss markup

**Installation**
1. `npm i css-loader style-loader --save-dev`


**webpack.config.js**
- specify `options` for the style-loader to also allow import processed by other loaders. (here: 1 loader, scss-loader)
```javascript
const config = {
  ...
  module: {
    rules: [
      {
          test: /\.css$/,
          use: [
            "style-loader",
            {
              loader: "css-loader",
              options: {
                importLoaders: 1,	// allows sass @import() stateements
              },
            },
            "scss-loader",
          ],
      },
    ],
  },
  ...
};
```

**Javascript Usage**
- Import css files in js files, where needed: `import "./styles.scss"`

**CSS Usage**
```css
@import "./variables.sass";
@import "./styles.css";
```
**Import directly from `node_modules`**
```css
@import "~bootstrap/less/bootstrap";
```

#### D. Separating CSS
- Standard css-loader inlines all styles - can be slower
- Flash of unstyled elements, since javascript needs to be loaded to apply styles

**webpack.config.js**
- **Production**: use MiniCssExtractPlugin.loader to aggregate CSS insteaad of style-loader (only use in production, heavy load)
```javascript
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const config = {
  ...
  plugins: [
    // push styling to a separate file
    new MiniCssExtractPlugin({
        filename: "[name].[hash].css",
        chunkFilename: "[id].[hash].css"
    })
  ],
    module: {
        rules: [
            {
            test: /\.(sa|sc|c)ss$/,
            use: [
                    MiniCssExtractPlugin.loader,    // instead of style-loader in dev mode, to aggregate css
                    {  // translates CSS into CommonJS
                      loader: "css-loader",
                      options: {
                        importLoaders: 1,   // allows sass @import() statements
                      },
                    },
                    'sass-loader'
                ],
            }
        ]
    },
  ...
};
```

#### E. Source Maps
- To retrace errors (debuggin) after files have been transformed


#### F. Build Caching
- add `cach-loader` before heavy loaders (e.g. babel)

```javascript
const config = {
  ...
  module: {
    // modules to transform other languages to js
    // pipe every file with this extension through the specified loaders
    rules: [
      {
        // React.js and Ecma Script Transpiler
        test: /\.jsx?$/,
        include: path.resolve(__dirname, 'src'),
        use: [
            'cache-loader', // enable caching for heavy loaders
            {
          loader: 'babel-loader',
          options: {
            presets: ['env', 'react']
          }
        }]
      },
   }
  ...
};
```




## Webpack Random


#### Development Wraps

Add to production config:
```javascript
plugins: [
    new webpack.DefinePlugin({
        'process.env.NODE_ENV': JSON.stringify('production')
    }),
    ...
]
```
And use in code (will be completely removed in production):
```javascript
if (__DEV__) {
  //do dev-only stuff that's not really interesting in production
}
```




