{include file="sections/header.tpl"}

<div class="row">
    <div class="col-md-6 col-sm-12 col-md-offset-3">
        <div class="panel panel-hovered panel-primary panel-stacked mb30">
            <div class="panel-heading">{$in['invoice']}</div>
            <div class="panel-body">
                <div class="well">
                    <fieldset>
                        <center>
                            <b>{$_c['CompanyName']}</b><br>
                            {$_c['address']}<br>
                            {$_c['phone']}<br>
                        </center>
                        ====================================================<br>
                        INVOICE: <b>{$in['invoice']}</b> - {Lang::T('Date')} : {$date}<br>
                        {Lang::T('Sales')} : {$_admin['fullname']}<br>
                        ====================================================<br>
                        {Lang::T('Type')} : <b>{$in['type']}</b><br>
                        {Lang::T('Plan Name')} : <b>{$in['plan_name']}</b><br>
                        {Lang::T('Plan Price')} : <b>{Lang::moneyFormat($in['price'])}</b><br>
                        {$in['method']}<br>
                        <br>
                        {Lang::T('Username')} : <b>{$in['username']}</b><br>
                        {Lang::T('Password')} : **********<br>
                        {if $in['type'] != 'Balance'}
                            <br>
                            {Lang::T('Created On')} : <b>{Lang::dateAndTimeFormat($in['recharged_on'],$in['recharged_time'])}</b><br>
                            {Lang::T('Expires On')} : <b>{Lang::dateAndTimeFormat($in['expiration'],$in['time'])}</b><br>
                        {/if}
                        =====================================================<br>
                        <center>{$_c['note']}</center>
                    </fieldset>
                </div>
                <form class="form-horizontal" method="post" action="{$_url}prepaid/print" target="_blank">
                    <input type="hidden" name="id" value="{$in['id']}">
                    <a href="{$_url}prepaid/list" class="btn btn-primary btn-sm"><i
                            class="ion-reply-all"></i>{Lang::T('Finish')}</a>
                    <a href="{$_url}prepaid/view/{$in['id']}/send" class="btn btn-info text-black btn-sm"><i
                        class="glyphicon glyphicon-envelope"></i> {Lang::T("Resend To Customer")}</a>
                    <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-print"></i>
                        {Lang::T('Click Here To Print')}</button>
                </form>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var s5_taf_parent = window.location;

    function popup_print() {
        window.open('print.php?page=<?php echo $_GET['
            act '];?>', 'page',
            'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=50,top=50,titlebar=yes'
            )
    }
</script>
{include file="sections/footer.tpl"}