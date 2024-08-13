<!DOCTYPE html>
<html>

<head>
    <title>{$_title} - {$_c['CompanyName']}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="ui/ui/styles/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="ui/ui/images/favicon.ico">

    <script type="text/javascript">
        function printpage() {
            window.print();
        }
    </script>
</head>

<body topmargin="0" leftmargin="0" onload="printpage()">
    <div class="row">
        <div class="col-md-12">
            <table width="200">
                <tr>
                    <td>
                        <fieldset>
                            <center>
                                <b>{$_c['CompanyName']}</b><br>
                                {$_c['address']}<br>
                                {$_c['phone']}<br>
                            </center>
                            ============================================<br>
                            INVOICE: <b>{$d['invoice']}</b> - {Lang::T('Date')} : {$date}<br>
                            {Lang::T('Sales')} : {$_admin['fullname']}<br>
                            ============================================<br>
                            {Lang::T('Type')} : <b>{$d['type']}</b><br>
                            {Lang::T('Plan Name')} : <b>{$d['plan_name']}</b><br>
                            {Lang::T('Plan Price')} : <b>{Lang::moneyFormat($d['price'])}</b><br>
                            <br>
                            {Lang::T('Username')} : <b>{$d['username']}</b><br>
                            {Lang::T('Password')} : **********<br>
                            {if $in['type'] != 'Balance'}
                                <br>
                                {Lang::T('Created On')} : <b>{Lang::dateAndTimeFormat($d['recharged_on'],$d['recharged_time'])}</b><br>
                                {Lang::T('Expires On')} : <b>{Lang::dateAndTimeFormat($d['expiration'],$d['time'])}</b><br>
                            {/if}
                            ============================================<br>
                            <center>{$_c['note']}</center>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script src="ui/ui/scripts/jquery-1.10.2.js"></script>
    <script src="ui/ui/scripts/bootstrap.min.js"></script>
    {if isset($xfooter)}
        {$xfooter}
    {/if}

</body>

</html>