{* Smarty *}
{strip}

{include file='./_header.tpl'}

<div class="container-fluid">
	<div class="row-fluid" id="approot">

		<div>
			<h1>
				{if $APP.confirmed}
					Your account has been confirmed
				{else}
					Oups
				{/if}
			</h1>
			<p>
				{if $APP.confirmed}
					You are now allowed to sign in with your account on our services.
				{else}
					{$APP.error}.
				{/if}
			</p>
		</div>
		<div>
			<a href="{$APP.url}" class="btn">Go back to {$APP.name}</a>
		</div>
	</div>
</div>

{include file='./_footer.tpl'}

{/strip}
