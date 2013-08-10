{* Smarty *}
{strip}

<div>
  <table cellspacing="0" cellpadding="8" border="0" style="width:100%;font-family:Arial,Sans-serif;font-size:13px;fborder-width:0;background-color:#fff;">
    <tr>
      <td>
        <div style="width:100%;padding:2px">
          <p>
            Hey,
          </p>
          <p>
            Your account has been permanently deleted from {$from.1}.
          </p>
          <p>
            Thank you for using {$from.1}, we hope you will be back soon!
          </p>
          <p>
            The {$from.1} team.
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="background-color:#fff;color:#888;font-family:Arial,Sans-serif;font-size:11px">
        <p>Confirmation sent from <a href="{$url}" style="color:#20c;white-space:nowrap">the {$from.1} team</a>.</p>
        <p>This is an automated message. Please, do not reply.</p>
      </td>
    </tr>
  </table>
</div>

{/strip}
