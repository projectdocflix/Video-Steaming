<div class="modal-header">
    <h5 class="modal-title">{{ __('Preview Template') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('email-notification.send-test-mail', $template->slug)}}" class="ajax"
                  data-handler="commonResponseWithPageLoad"
                  method="post">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <div class="input__group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" placeholder="{{ __('Email') }}" value=""
                                   required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mt-3">
                            <button type="submit" class="btn btn-blue mr-30">{{__('Send Test Mail')}}</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <style>
                /* Default Styles for HTML Tags */
                #dynamic-content a:link {
                    color: internal value;
                    text-decoration: underline;
                    cursor: auto;
                }
                #dynamic-content a:visited {
                    color: internal value;
                    text-decoration: underline;
                    cursor: auto;
                }
                #dynamic-content a:link:active {
                    color: internal value;
                }
                #dynamic-content a:visited:active {
                    color: internal value;
                }
                #dynamic-content address {
                    display: block;
                    font-style: italic;
                }
                #dynamic-content area {
                    display: none;
                }
                #dynamic-content article {
                    display: block;
                }
                #dynamic-content aside {
                    display: block;
                }
                #dynamic-content b {
                    font-weight: bold;
                }
                #dynamic-content bdo {
                    unicode-bidi: bidi-override;
                }
                #dynamic-content blockquote {
                    display: block;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 40px;
                    margin-right: 40px;
                }
                #dynamic-content body {
                    display: block;
                    margin: 8px;
                }
                #dynamic-content body:focus {
                    outline: none;
                }
                #dynamic-content caption {
                    display: table-caption;
                    text-align: center;
                }
                #dynamic-content cite {
                    font-style: italic;
                }
                #dynamic-content code {
                    font-family: monospace;
                }
                #dynamic-content col {
                    display: table-column;
                }
                #dynamic-content colgroup {
                    display: table-column-group;
                }
                #dynamic-content datalist {
                    display: none;
                }
                #dynamic-content dd {
                    display: block;
                    margin-left: 40px;
                }
                #dynamic-content del {
                    text-decoration: line-through;
                }
                #dynamic-content details {
                    display: block;
                }
                #dynamic-content dfn {
                    font-style: italic;
                }
                #dynamic-content div {
                    display: block;
                }
                #dynamic-content dl {
                    display: block;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                }
                #dynamic-content dt {
                    display: block;
                }
                #dynamic-content em {
                    font-style: italic;
                }
                #dynamic-content embed:focus {
                    outline: none;
                }
                #dynamic-content fieldset {
                    display: block;
                    margin-left: 2px;
                    margin-right: 2px;
                    padding-top: 0.35em;
                    padding-bottom: 0.625em;
                    padding-left: 0.75em;
                    padding-right: 0.75em;
                    border: 2px groove internal value;
                }
                #dynamic-content figcaption {
                    display: block;
                }
                #dynamic-content figure {
                    display: block;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 40px;
                    margin-right: 40px;
                }
                #dynamic-content footer {
                    display: block;
                }
                #dynamic-content form {
                    display: block;
                    margin-top: 0em;
                }
                #dynamic-content h1 {
                    display: block;
                    font-size: 2em;
                    margin-top: 0.67em;
                    margin-bottom: 0.67em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content h2 {
                    display: block;
                    font-size: 1.5em;
                    margin-top: 0.83em;
                    margin-bottom: 0.83em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content h3 {
                    display: block;
                    font-size: 1.17em;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content h4 {
                    display: block;
                    margin-top: 1.33em;
                    margin-bottom: 1.33em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content h5 {
                    display: block;
                    font-size: 0.83em;
                    margin-top: 1.67em;
                    margin-bottom: 1.67em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content h6 {
                    display: block;
                    font-size: 0.67em;
                    margin-top: 2.33em;
                    margin-bottom: 2.33em;
                    margin-left: 0;
                    margin-right: 0;
                    font-weight: bold;
                }
                #dynamic-content head {
                    display: none;
                }
                #dynamic-content header {
                    display: block;
                }
                #dynamic-content hr {
                    display: block;
                    margin-top: 0.5em;
                    margin-bottom: 0.5em;
                    margin-left: auto;
                    margin-right: auto;
                    border-style: inset;
                    border-width: 1px;
                }
                #dynamic-content html {
                    display: block;
                }
                #dynamic-content html:focus {
                    outline: none;
                }
                #dynamic-content i {
                    font-style: italic;
                }
                #dynamic-content iframe:focus {
                    outline: none;
                }
                #dynamic-content iframe[seamless] {
                    display: block;
                }
                #dynamic-content img {
                    display: inline-block;
                }
                #dynamic-content ins {
                    text-decoration: underline;
                }
                #dynamic-content kbd {
                    font-family: monospace;
                }
                #dynamic-content label {
                    cursor: default;
                }
                #dynamic-content legend {
                    display: block;
                    padding-left: 2px;
                    padding-right: 2px;
                    border: none;
                }
                #dynamic-content li {
                    display: list-item;
                }
                #dynamic-content link {
                    display: none;
                }
                #dynamic-content map {
                    display: inline;
                }
                #dynamic-content mark {
                    background-color: yellow;
                    color: black;
                }
                #dynamic-content menu {
                    display: block;
                    list-style-type: disc;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                    padding-left: 40px;
                }
                #dynamic-content nav {
                    display: block;
                }
                #dynamic-content object:focus {
                    outline: none;
                }
                #dynamic-content ol {
                    display: block;
                    list-style-type: decimal;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                    padding-left: 40px;
                }
                #dynamic-content output {
                    display: inline;
                }
                #dynamic-content p {
                    display: block;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                }
                #dynamic-content param {
                    display: none;
                }
                #dynamic-content pre {
                    display: block;
                    font-family: monospace;
                    white-space: pre;
                    margin: 1em 0;
                }
                #dynamic-content q {
                    display: inline;
                }
                #dynamic-content q::before {
                    content: open-quote;
                }
                #dynamic-content q::after {
                    content: close-quote;
                }
                #dynamic-content rt {
                    line-height: normal;
                }
                #dynamic-content s {
                    text-decoration: line-through;
                }
                #dynamic-content samp {
                    font-family: monospace;
                }
                #dynamic-content script {
                    display: none;
                }
                #dynamic-content section {
                    display: block;
                }
                #dynamic-content small {
                    font-size: smaller;
                }
                #dynamic-content strike {
                    text-decoration: line-through;
                }
                #dynamic-content strong {
                    font-weight: bold;
                }
                #dynamic-content style {
                    display: none;
                }
                #dynamic-content sub {
                    vertical-align: sub;
                    font-size: smaller;
                }
                #dynamic-content summary {
                    display: block;
                }
                #dynamic-content sup {
                    vertical-align: super;
                    font-size: smaller;
                }
                #dynamic-content table {
                    display: table;
                    border-collapse: separate;
                    border-spacing: 2px;
                    border-color: gray;
                }
                #dynamic-content tbody {
                    display: table-row-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                #dynamic-content td {
                    display: table-cell;
                    vertical-align: inherit;
                }
                #dynamic-content tfoot {
                    display: table-footer-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                #dynamic-content th {
                    display: table-cell;
                    vertical-align: inherit;
                    font-weight: bold;
                    text-align: center;
                }
                #dynamic-content thead {
                    display: table-header-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                #dynamic-content title {
                    display: none;
                }
                #dynamic-content tr {
                    display: table-row;
                    vertical-align: inherit;
                    border-color: inherit;
                }
                #dynamic-content u {
                    text-decoration: underline;
                }
                #dynamic-content ul {
                    display: block;
                    list-style-type: disc;
                    margin-top: 1em;
                    margin-bottom: 1em;
                    margin-left: 0;
                    margin-right: 0;
                    padding-left: 40px;
                }
                #dynamic-content var {
                    font-style: italic;
                }
            </style>
            <div id="dynamic-content">
                {!! $template->body !!}
            </div>
        </div>
    </div>
</div>
