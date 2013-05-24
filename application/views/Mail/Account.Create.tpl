{* Smarty *}
{strip}

<div>
  <table cellspacing="0" cellpadding="8" border="0" style="width:100%;font-family:Arial,Sans-serif;border-width:0;background-color:#fff;">
    <tr>
      <td>
        <div style="width:100%;padding:2px">
          <h3 style="padding:0 0 6px 0;margin:0;font-family:Arial,Sans-serif;font-size:16px;font-weight:bold;color:#222">{$title}</h3>
          <table cellpadding="0" cellspacing="0" border="0">
            <tr>
              <td style="padding:0 1em 10px 0;font-family:Arial,Sans-serif;font-size:13px;color:#888;white-space:nowrap" valign="top">
                <div><i style="font-style:normal">Nom d'utilisateur</i></div>
              </td>
              <td style="padding-bottom:10px;font-family:Arial,Sans-serif;font-size:13px;color:#222" valign="top">
                {$email}
              </td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td style="background-color:#fff;color:#888;font-family:Arial,Sans-serif;font-size:11px">
        <p>Confirmation d'inscription de <a href="{$url}" style="color:#20c;white-space:nowrap">{$from.1}</a>.</p>
        <p>Ceci est un message automatique, merci de ne pas y répondre.</p>
      </td>
    </tr>
  </table>
</div>

{/strip}
