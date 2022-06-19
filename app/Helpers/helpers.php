<?php

if (! function_exists('humanize_dashed_column')) {
    function humanize_dashed_column($column)
    {
        return \Illuminate\Support\Str::title(str_replace('_', ' ', $column));
    }
}

if (! function_exists('get_target')) {
    function get_target($openInNewTab)
    {
        return $openInNewTab ? '_blank' : '_self';
    }
}

if (! function_exists('get_cell_data')) {
    function get_cell_data($resource, $column, $cell)
    {
        $return = $cell;

        if ($resource['resource_type']->name === \App\Enums\ResourceType::PDF) {
            if ($column === 'url') {
                $pdfDownloadURL = route('web.front.resources.download', ['fileName' => $cell]);
                $return = <<<PDF_DOWNLOAD
<a href="$pdfDownloadURL">$return</a>
PDF_DOWNLOAD;
            }
        } elseif ($resource['resource_type']->name === \App\Enums\ResourceType::HTML) {
            if ($column === 'code_snippet') {
                $return = <<<CODE_SNIPPET
<div class="row">
    <div class="col">
        <button onclick="copyToClipboard()" class="btn btn-primary float-end">
            <span class="tooltiptext" id="code_snippet_copy_tooltip">Copy to clipboard</span>
            <span id="copy_to_clipboard_button_text">Copy code snippet</span>
        </button>
    </div>
</div>
<div class="row">
    <div class="col">
        <textarea id="code_snippet" class="form-control form-control-xl border-0" disabled aria-disabled="true" rows="10">$return</textarea>
    </div>
</div>
CODE_SNIPPET;
            }
        } elseif ($resource['resource_type']->name === \App\Enums\ResourceType::LINK) {
            if ($column === 'url') {
                $target = get_target($resource['open_in_new_tab']);
                $return = <<<URL
<a href="$return" target="{$target}">$return</a>
URL;
            }
        }

        return $return;
    }
}
