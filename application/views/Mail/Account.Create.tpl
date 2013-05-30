{* Smarty *}
{strip}

<div>
  <table cellspacing="0" cellpadding="8" border="0" style="width:100%;font-family:Arial,Sans-serif;border-width:0;background-color:#fff;">
    <tr>
      <td>
        <div style="width:100%;padding:2px">
          <h3 style="padding:0 0 6px 0;margin:0;font-family:Arial,Sans-serif;font-size:16px;font-weight:bold;color:#222">{$title}</h3>
          <p style="padding:0 1em 10px 0;font-family:Arial,Sans-serif;font-size:13px;color:#888;white-space:nowrap">
            Please confirm your email address by <a href="{$url}/account/confirm/{$to.id}">clicking this link</a> and you're ready to go.
          </p>
          <p>
            {$from.1}
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="background-color:#fff;color:#888;font-family:Arial,Sans-serif;font-size:11px">
        <p>Confirmation sent from <a href="{$url}" style="color:#20c;white-space:nowrap">{$from.1}</a>.</p>
        <p>This is an automated message. Please, do not reply.</p>
      </td>
    </tr>
  </table>
</div>

{/strip}
