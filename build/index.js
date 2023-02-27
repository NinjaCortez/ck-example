/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/dropdown-color-picker/index.js":
/*!*******************************************************!*\
  !*** ./src/components/dropdown-color-picker/index.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */
const {
  Button,
  Dropdown,
  ColorIndicator,
  ColorPicker,
  Tooltip
} = wp.components;
const DropdownColorPicker = props => {
  const {
    label,
    value,
    onChange,
    ...attrs
  } = props;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Dropdown, {
    className: "components-color-palette__item-wrapper",
    contentClassName: "components-color-palette__picker",
    renderToggle: _ref => {
      let {
        isOpen,
        onToggle
      } = _ref;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
        className: "components-color-palette__item",
        onClick: onToggle,
        "aria-expanded": isOpen
      }, attrs), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ColorIndicator, {
        colorValue: value
      }), label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, label));
    },
    renderContent: () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(ColorPicker, {
      color: value,
      onChangeComplete: color => onChange(color.hex),
      disableAlpha: true
    })
  });
};
/* harmony default export */ __webpack_exports__["default"] = (DropdownColorPicker);

/***/ }),

/***/ "./src/components/panel-save-button-row/index.js":
/*!*******************************************************!*\
  !*** ./src/components/panel-save-button-row/index.js ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */
const {
  __
} = wp.i18n;
const {
  Button,
  PanelRow
} = wp.components;

/**
 * Renders A Panel Row With a Save Button
 */

const PanelSaveButtonRow = props => {
  const {
    isSaving,
    onClick,
    ...attrs
  } = props;
  let {
    label
  } = props;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(PanelRow, {
    className: "ckexample-panel-bottom-button-row"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(Button, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    isPrimary: true,
    isLarge: true,
    disabled: isSaving,
    onClick: onClick
  }, attrs), label = label || __('Save')));
};
/* harmony default export */ __webpack_exports__["default"] = (PanelSaveButtonRow);

/***/ }),

/***/ "./src/components/range-selector/index.js":
/*!************************************************!*\
  !*** ./src/components/range-selector/index.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */
const {
  __
} = wp.i18n;
const {
  BaseControl,
  RangeControl
} = wp.components;

/**
 * Renders A Stylized Range Control
 */

const RangeController = props => {
  const {
    value,
    isSaving,
    onChange,
    ...attrs
  } = props;
  let {
    arrowDown,
    arrowUp,
    label,
    help,
    marks,
    more,
    min,
    max,
    trackColor,
    railColor
  } = props;
  arrowDown = arrowDown || 'arrow-down-alt2';
  arrowUp = arrowUp || 'arrow-up-alt2';
  more = more || 'more';
  trackColor = trackColor || 'green';
  railColor = railColor || 'red';
  min = min || 0;
  max = max || 10;
  if (!marks) {
    marks = Array.from({
      length: 6
    }, (v, i) => ({
      value: i * 2,
      label: i * 2
    }));
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(RangeControl, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_0__["default"])({
    className: "ckexample-range-control",
    label: label,
    help: help = help || '',
    beforeIcon: arrowDown,
    afterIcon: arrowUp,
    allowReset: false,
    resetFallbackValue: 3,
    step: 1,
    withInputField: false,
    icon: more,
    separatorType: "none",
    trackColor: trackColor,
    isShiftStepEnabled: true,
    marks: marks,
    railColor: railColor,
    value: value,
    onChange: onChange,
    min: min,
    max: max,
    disabled: isSaving
  }, attrs));
};
/* harmony default export */ __webpack_exports__["default"] = (RangeController);

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/notices */ "@wordpress/notices");
/* harmony import */ var _wordpress_notices__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_notices__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_dropdown_color_picker__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/dropdown-color-picker */ "./src/components/dropdown-color-picker/index.js");
/* harmony import */ var _components_panel_save_button_row__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/panel-save-button-row */ "./src/components/panel-save-button-row/index.js");
/* harmony import */ var _components_range_selector__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./components/range-selector */ "./src/components/range-selector/index.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");

/**
 * WordPress dependencies
 */
const {
  __
} = wp.i18n;
const {
  BaseControl,
  Button,
  ExternalLink,
  PanelBody,
  PanelRow,
  Placeholder,
  SelectControl,
  SnackbarList,
  Spinner,
  TextareaControl,
  ToggleControl
} = wp.components;
const {
  render,
  Component,
  Fragment,
  lazy,
  Suspense
} = wp.element;



/**
 * Internal dependencies
 */





/**
 * Update Notices
 */
const Notices = () => {
  const notices = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useSelect)(select => select(_wordpress_notices__WEBPACK_IMPORTED_MODULE_1__.store).getNotices().filter(notice => notice.type === 'snackbar'), []);
  const {
    removeNotice
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.useDispatch)(_wordpress_notices__WEBPACK_IMPORTED_MODULE_1__.store);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SnackbarList, {
    className: "edit-site-notices",
    notices: notices,
    onRemove: removeNotice
  });
};
const TitleIcon = (icon, label) => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "ckexample-title-icon"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: 'dashicons dashicons-' + icon
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, label));
};

/**
 * CK Example App Component
 */
class App extends Component {
  constructor() {
    super(...arguments);
    this.saveSettings = this.saveSettings.bind(this);
    this.ckexampleData = ckexampleData || {};
    this.ckexampleData.defaults.isAPILoaded = false;
    this.ckexampleData.defaults.isAPISaving = false;
    this.state = this.ckexampleData.defaults;
    this.ns = ckexampleData.ns;
    this.i18n = ckexampleData.i18n;
  }
  componentDidMount() {
    wp.api.loadPromise.then(() => {
      this.settings = new wp.api.models.Settings();
      if (false === this.state.isAPILoaded) {
        this.settings.fetch().then(response => {
          response.ckexample_settings = response.ckexample_settings || {};
          response.ckexample_settings.isAPILoaded = true;
          this.setState(response.ckexample_settings);
        });
      }
    });
  }
  saveSettings(keys) {
    let message = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    this.setState({
      isAPISaving: true
    });
    for (let key of keys) {
      this.ckexampleData.settings[key] = this.state[key];
    }
    const model = new wp.api.models.Settings({
      ckexample_settings: this.ckexampleData.settings
    });
    model.save().then(response => {
      this.setState({
        isAPISaving: false
      });
    });
    (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_2__.dispatch)('core/notices').createNotice('success', message = message || __('Settings Saved', this.ns), {
      type: 'snackbar',
      isDismissible: true
    });
  }
  render() {
    if (!this.state.isAPILoaded) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Placeholder, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Spinner, null));
    }
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "ckexample-main"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      title: TitleIcon('networking', __('Integration Settings', this.ns))
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BaseControl, {
      label: __('API Key', this.ns),
      help: 'In order to use CK Example, you need to enter your API key.',
      id: "ckexample-options-api-key",
      className: "ckexample-text-field"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("input", {
      type: "text",
      id: "ckexample-options-api-key",
      value: this.state.api_key,
      placeholder: __('API Key', this.ns),
      disabled: this.state.isAPISaving,
      onChange: e => this.setState({
        api_key: e.target.value
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "ckexample-text-field-button-group"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ExternalLink, {
      href: "#"
    }, __('Get API Key', this.ns))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_range_selector__WEBPACK_IMPORTED_MODULE_5__["default"], {
      label: __('API Retry Attempts', this.ns),
      help: __('Max amount of times to retry failed API attempts', this.ns),
      value: this.state.api_timeout
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
      label: __('Log API Interactions?', this.ns),
      help: __('Would you like to keep a log of API Interactions?', this.ns),
      checked: this.state.api_log,
      onChange: e => this.setState({
        api_log: e
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_panel_save_button_row__WEBPACK_IMPORTED_MODULE_4__["default"], {
      label: __('Save Integration Settings', this.ns),
      isSaving: this.state.isAPISaving,
      onClick: () => this.saveSettings(['api_key', 'api_log'], __('Integration Settings Saved', this.ns))
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      initialOpen: false,
      title: TitleIcon('art', __('Branding', this.ns))
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dropdown_color_picker__WEBPACK_IMPORTED_MODULE_3__["default"], {
      label: __('Primary Color', this.ns),
      value: this.state.primary_color,
      onChange: e => this.setState({
        primary_color: e
      })
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_dropdown_color_picker__WEBPACK_IMPORTED_MODULE_3__["default"], {
      label: __('Accent Color', this.ns),
      value: this.state.accent_color,
      onChange: e => this.setState({
        accent_color: e
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(BaseControl, {
      label: __('Tagline', this.ns),
      id: "ckexample-options-api-key",
      className: "ckexample-text-field"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(TextareaControl, {
      value: this.state.tagline,
      placeholder: __('Add Tagline text', this.ns),
      onChange: e => this.setState({
        tagline: e
      })
    }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_panel_save_button_row__WEBPACK_IMPORTED_MODULE_4__["default"], {
      label: __('Save Branding Settings', this.ns),
      isSaving: this.state.isAPISaving,
      onClick: () => this.saveSettings(['primary_color', 'accent_color', 'tagline'], __('Branding Settings Saved', this.ns))
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, {
      initialOpen: false,
      title: TitleIcon('hammer', __('Maintenance', this.ns))
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelRow, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(ToggleControl, {
      label: __('Cleanup On Uninstallation', this.ns),
      help: __('This setting will remove all CK Example plugin when uninstalled.', this.ns),
      checked: this.state.cleanup,
      onChange: e => this.setState({
        cleanup: e
      })
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_panel_save_button_row__WEBPACK_IMPORTED_MODULE_4__["default"], {
      isSaving: this.state.isAPISaving,
      onClick: () => this.saveSettings(['cleanup'])
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(PanelBody, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "ckexample-info"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", null, __('Got a question for us?', this.ns)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, __('We would love to help you out if you need assistance.', this.ns)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "ckexample-info-button-group"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      variant: "secondary",
      isLarge: true,
      target: "_blank",
      href: "#"
    }, __('Ask a question', this.ns)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Button, {
      variant: "secondary",
      isLarge: true,
      target: "_blank",
      href: "#"
    }, __('Leave a review', this.ns)))))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "ckexample-notices"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(Notices, null)));
  }
}
document.addEventListener('DOMContentLoaded', () => {
  const renderID = ckexampleData.renderID || false;
  console.log({
    func: 'DOMContentLoaded',
    data: ckexampleData,
    renderID: renderID
  });
  if (renderID) {
    const htmlOutput = document.getElementById(renderID);
    if (htmlOutput) {
      render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(App, null), htmlOutput);
    }
  }
});

/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/notices":
/*!*********************************!*\
  !*** external ["wp","notices"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["notices"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _extends; }
/* harmony export */ });
function _extends() {
  _extends = Object.assign ? Object.assign.bind() : function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];
      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }
    return target;
  };
  return _extends.apply(this, arguments);
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkckexample_admin"] = self["webpackChunkckexample_admin"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], function() { return __webpack_require__("./src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map