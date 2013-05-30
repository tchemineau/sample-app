<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>{$APP.name}</title>
	<link href="assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<div class="container-fluid">
		<div class="row-fluid" id="approot">

			<div>
				<h1>
					{if $APP.confirm}
						Your account has been confirmed
					{else}
						Oups
					{/if}
				</h1>
				<p>
					{if $APP.confirm}
						You are now allowed to sign in with your account on our services.
					{else}
						{$APP.error}.
					{/if}
				</p>
			</div>
			<div>
				<a href="{$APP.url}" class="btn">Go to {$APP.name}</a>
			</div>

		</div>
	</div>

</body>
</html>
