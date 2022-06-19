window.copyToClipboard = function() {
    let copyText = document.getElementById("code_snippet");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);

    let tooltip = document.getElementById("code_snippet_copy_tooltip");
    tooltip.innerHTML = "Copied!";
    let copyToClipboardButtonText = document.getElementById("copy_to_clipboard_button_text");
    copyToClipboardButtonText.innerHTML = "Copied!";
}

window.copiedFunc = function() {
    let tooltip = document.getElementById("code_snippet_copy_tooltip");
    tooltip.innerHTML = "Copy to clipboard";
}
