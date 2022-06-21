window.copyToClipboard = function() {
    let copyText = document.getElementById("code_snippet");
    copyText.focus();
    copyText.select();

    const range = document.createRange();
    range.selectNode(copyText);
    window.getSelection().addRange(range);

    let copyOperationStatus = false;
    let mssg = 'Can not Copied!';

    if (typeof (navigator.clipboard) == 'undefined') {
        try {
            copyOperationStatus = document.execCommand('copy');
        } catch (err) {
            copyOperationStatus = false;
        }
    } else if(typeof (navigator.clipboard) !== 'undefined') {
        navigator.clipboard.writeText(copyText.value);
        copyOperationStatus = true;
    } else {
        window.clipboardData.setData("Text", copyText.value);
    }

    if(copyOperationStatus) {
        mssg = "Copied!";
    }

    let tooltip = document.getElementById("code_snippet_copy_tooltip");
    tooltip.innerHTML = mssg;
    let copyToClipboardButtonText = document.getElementById("copy_to_clipboard_button_text");
    copyToClipboardButtonText.innerHTML = mssg;
    window.getSelection().removeAllRanges();
}

window.copiedFunc = function() {
    let tooltip = document.getElementById("code_snippet_copy_tooltip");
    tooltip.innerHTML = "Copy to clipboard";
}
