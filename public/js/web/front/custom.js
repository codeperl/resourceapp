/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./resources/js/web/front/custom.js ***!
  \******************************************/
window.copyToClipboard = function () {
  var copyText = document.getElementById("code_snippet");
  copyText.focus();
  copyText.select();
  /*copyText.setSelectionRange(0, 99999);*/

  var range = document.createRange();
  range.selectNode(copyText);
  window.getSelection().addRange(range);
  var copyOperationStatus = false;
  var mssg = 'Can not Copied!';

  if (typeof navigator.clipboard == 'undefined') {
    try {
      copyOperationStatus = document.execCommand('copy');
      console.log(copyOperationStatus);
    } catch (err) {
      copyOperationStatus = false;
    }
  } else if (typeof navigator.clipboard !== 'undefined') {
    navigator.clipboard.writeText(copyText.value);
    copyOperationStatus = true;
  } else {
    window.clipboardData.setData("Text", copyText.value);
  }

  if (copyOperationStatus) {
    mssg = "Copied!";
  }

  var tooltip = document.getElementById("code_snippet_copy_tooltip");
  tooltip.innerHTML = mssg;
  var copyToClipboardButtonText = document.getElementById("copy_to_clipboard_button_text");
  copyToClipboardButtonText.innerHTML = mssg;
  window.getSelection().removeAllRanges();
};

window.copiedFunc = function () {
  var tooltip = document.getElementById("code_snippet_copy_tooltip");
  tooltip.innerHTML = "Copy to clipboard";
};
/******/ })()
;