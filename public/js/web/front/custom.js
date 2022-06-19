/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/web/front/custom.js ***!
  \******************************************/
window.copyToClipboard = function () {
  var copyText = document.getElementById("code_snippet");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  var tooltip = document.getElementById("code_snippet_copy_tooltip");
  tooltip.innerHTML = "Copied!";
  var copyToClipboardButtonText = document.getElementById("copy_to_clipboard_button_text");
  copyToClipboardButtonText.innerHTML = "Copied!";
};

window.copiedFunc = function () {
  var tooltip = document.getElementById("code_snippet_copy_tooltip");
  tooltip.innerHTML = "Copy to clipboard";
};
/******/ })()
;