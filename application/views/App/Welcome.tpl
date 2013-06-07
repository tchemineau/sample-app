{* Smarty *}
{strip}

{include file='./_header.tpl'}

<div class="row-fluid" id="approot"></div>

<script id="app" type="text/javascript" src="{$APP.url}assets/app/require.js" data-main="{$APP.url}assets/app/main" data-fragment="{$APP.fragment}"></script>

{include file='./_footer.tpl'}

{/strip}
