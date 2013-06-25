{* Smarty *}
<!DOCTYPE html>
{strip}

<html>
<head>
        <meta charset="utf-8" />
        <title>{$APP.name}</title>
        <base href="{$APP.url}" />

        <link href="{$APP.url}static/library/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{$APP.url}assets/css/bootstrap-jumbotron.css" rel="stylesheet" type="text/css" />
        <link href="{$APP.url}assets/css/app.css" rel="stylesheet" type="text/css" />

	<script>
		var CONFIG = {
			name: '{$APP.name}',
			url: '{$APP.url}'
		};
	</script>
</head>

<body>

<div class="row-fluid" id="appprogress-container">
	<div class="row-fluid" id="appprogress"><i class="icon-refresh"></i></div>
</div>

{/strip}
