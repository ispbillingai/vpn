{include file="sections/header.tpl"}

<form class="form-horizontal" method="post" role="form" action="{$_url}settings/app-post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-primary panel-hovered panel-stacked mb30">
<div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
    <span>{Lang::T('General Settings')}</span>
    <div class="btn-group">
        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-right: 10px;">
            {Lang::T('Need Help?')}
        </button>
        <button class="btn btn-primary btn-xs" title="save" type="submit">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
        </button>
    </div>
</div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Application Name/ Company Name')}</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" id="CompanyName" name="CompanyName"
                                value="{$_c['CompanyName']}">
                        </div>
                       <span class="help-block col-md-4">{Lang::T('This Name will be shown on the Title')}</span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Company Logo')}</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            <span class="help-block">For PDF Reports | Best size 1078 x 200 | uploaded image will be
                                autosize</span>
                        </div>
                        <span class="help-block col-md-4">
                            <a href="./{$logo}" target="_blank"><img src="./{$logo}" height="48" alt="logo for PDF"></a>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Company Footer')}</label>
                        <div class="col-md-6">
                            <input type="text" required class="form-control" id="CompanyFooter" name="CompanyFooter"
                                value="{$_c['CompanyFooter']}">
                        </div>
                        <span class="help-block col-md-4">{Lang::T('Will show below user pages')}</span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Address')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="address" name="address"
                                rows="3">{Lang::htmlspecialchars($_c['address'])}</textarea>
                        </div>
                       <span class="help-block col-md-4">{Lang::T('You can use html tag')}</span>
                    </div>
<div class="form-group">
    <label class="col-md-2 control-label">{Lang::T('Phone Number')}</label>
    <div class="col-md-6">
        <input type="text" class="form-control" id="phone" name="phone" value="{$_c['phone']}">
    </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">{Lang::T('Router Status Notification No')}</label>
    <div class="col-md-6">
        <input type="text" class="form-control" id="router_notifications" name="router_notifications" value="{$_c['router_notifications']}">
    </div>
</div>


                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Invoice Footer')}</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="api_key" name="api_key"
                                value="{$_c['api_key']}" placeholder="Empty this to randomly created API key"
                                onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'">
                        </div>
                        <p class="col-md-4 help-block">{Lang::T('This Token will act as SuperAdmin/Admin')}</p>                        
                    </div>                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">APP URL</label>
                        <div class="col-md-6">
                            <input type="text" readonly class="form-control" value="{$app_url}">
                        </div>
                        <p class="help-block col-md-4">edit at config.php</p>
                    </div>
                </div>







                <div class="panel-heading" id="hide_dashboard_content">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    Hide Dashboard Content
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><input type="checkbox" name="hide_mrc" value="yes"
                                {if $_c['hide_mrc'] eq 'yes'}checked{/if}>
                            {Lang::T('Monthly Registered Customers')}</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_tms" value="yes"
                                {if $_c['hide_tms'] eq 'yes'}checked{/if}> {Lang::T('Total Monthly Sales')}</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_aui" value="yes"
                                {if $_c['hide_aui'] eq 'yes'}checked{/if}> {Lang::T('All Users Insights')}</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_al" value="yes"
                                {if $_c['hide_al'] eq 'yes'}checked{/if}> {Lang::T('Activity Log')}</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_uet" value="yes"
                                {if $_c['hide_uet'] eq 'yes'}checked{/if}> {Lang::T('User Expiring, Today')}</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_vs" value="yes"
                                {if $_c['hide_vs'] eq 'yes'}checked{/if}> Vouchers Stock</label>
                        <label class="col-md-2 control-label"><input type="checkbox" name="hide_pg" value="yes"
                                {if $_c['hide_pg'] eq 'yes'}checked{/if}> Payment Gateway</label>
                    </div>
                </div>









                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    Voucher
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Disable Voucher')}</label>
                        <div class="col-md-6">
                            <select name="disable_voucher" id="disable_voucher" class="form-control">
                                <option value="no" {if $_c['disable_voucher'] == 'no'}selected="selected" {/if}>No
                                </option>
                                <option value="yes" {if $_c['disable_voucher'] == 'yes'}selected="selected" {/if}>Yes
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">{Lang::T('Voucher activation menu will be hidden')}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Voucher Format')}</label>
                        <div class="col-md-6">
                            <select name="voucher_format" id="voucher_format" class="form-control">
                                <option value="up" {if $_c['voucher_format'] == 'up'}selected="selected" {/if}>UPPERCASE
                                </option>
                                <option value="low" {if $_c['voucher_format'] == 'low'}selected="selected" {/if}>
                                    lowercase
                                </option>
                                <option value="rand" {if $_c['voucher_format'] == 'rand'}selected="selected" {/if}>
                                    RaNdoM
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">UPPERCASE lowercase RaNdoM</p>
                    </div>
                    {if $_c['disable_voucher'] != 'yes'}
                        <div class="form-group">
                            <label class="col-md-2 control-label">{Lang::T('Disable Registration')}</label>
                            <div class="col-md-6">
                                <select name="disable_registration" id="disable_registration" class="form-control">
                                    <option value="no" {if $_c['disable_registration'] == 'no'}selected="selected" {/if}>No
                                    </option>
                                    <option value="yes" {if $_c['disable_registration'] == 'yes'}selected="selected" {/if}>
                                        Yes
                                    </option>
                                </select>
                            </div>
                            <p class="help-block col-md-4">
                                {Lang::T('Customer just Login with Phone number and Voucher Code, Voucher will be password')}
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Redirect after Activation</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="voucher_redirect" name="voucher_redirect"
                                    placeholder="https://192.168.88.1/status" value="{$voucher_redirect}">
                            </div>
                            <p class="help-block col-md-4">
                                {Lang::T('After Customer activate voucher or login, customer will be redirected to this url')}
                            </p>
                        </div>
                    {/if}
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">


                    
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    FreeRadius
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Enable Radius</label>
                        <div class="col-md-6">
                            <select name="radius_enable" id="radius_enable" class="form-control text-muted">
                                <option value="0">No</option>
                                <option value="1" {if $_c['radius_enable']}selected="selected" {/if}>Yes</option>
                            </select>
                        </div>
                        <p class="help-block col-md-4"><a
                                href="https://freeispradius.com"
                                target="_blank">Radius Instructions</a></p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Radius Client</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="radius_client" value="{$_c['radius_client']}">
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Balance System')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Enable System')}</label>
                        <div class="col-md-6">
                            <select name="enable_balance" id="enable_balance" class="form-control">
                                <option value="no" {if $_c['enable_balance'] == 'no'}selected="selected" {/if}>No
                                </option>
                                <option value="yes" {if $_c['enable_balance'] == 'yes'}selected="selected" {/if}>Yes
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">{Lang::T('Customer can deposit money to buy voucher')}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Allow Transfer')}</label>
                        <div class="col-md-6">
                            <select name="allow_balance_transfer" id="allow_balance_transfer" class="form-control">
                                <option value="no" {if $_c['allow_balance_transfer'] == 'no'}selected="selected" {/if}>
                                    No</option>
                                <option value="yes" {if $_c['allow_balance_transfer'] == 'yes'}selected="selected"
                                    {/if}>Yes</option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">{Lang::T('Allow balance transfer between customers')}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Minimum Balance Transfer')}</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" id="minimum_transfer" name="minimum_transfer"
                                value="{$_c['minimum_transfer']}">
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <a class="btn btn-success btn-xs" style="color: black;" href="javascript:testTg()">Test TG</a>
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Telegram Notification')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Telegram Bot Token</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="telegram_bot" name="telegram_bot"
                                onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'"
                                value="{$_c['telegram_bot']}" placeholder="123456:asdasgdkuasghddlashdashldhalskdklasd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Telegram User/Channel/Group ID</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="telegram_target_id" name="telegram_target_id"
                                value="{$_c['telegram_target_id']}" placeholder="12345678">
                        </div>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">You will get Payment and Error
                        notification</small>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                       <a class="btn btn-success btn-xs" style="color: black;" href="javascript:testSms()">Test SMS</a>
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('SMS OTP Registration')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">SMS Server URL</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="sms_url" name="sms_url" value="{$_c['sms_url']}"
                                placeholder="https://domain/?param_number=[number]&param_text=[text]&secret=">
                        </div>
                        <p class="help-block col-md-4">Must include <b>[text]</b> &amp; <b>[number]</b>, it will be
                            replaced.
                        </p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Or use Mikrotik SMS</label>
                        <div class="col-md-6">
                            <select class="form-control"
                                onchange="document.getElementById('sms_url').value = this.value">
                                <option value="">Select Router</option>
                                {foreach $r as $rs}
                                    <option value="{$rs['name']}" {if $rs['name']==$_c['sms_url']}selected{/if}>
                                        {$rs['name']}</option>
                                {/foreach}
                            </select>
                        </div>
                        <p class="help-block col-md-4">Must include <b>[text]</b> &amp; <b>[number]</b>, it will be
                            replaced.
                        </p>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">You can use WhatsApp  here too. <a
                            href="https://sms.freeispradius.com" target="_blank">Free Server</a></small>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                       <a class="btn btn-success btn-xs" style="color: black;" href="javascript:testWa()">Test WA</a>
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Whatsapp Notification')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Whatsapp Server URL</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="wa_url" name="wa_url" value="{$_c['wa_url']}"
                                placeholder="https://domain/?param_number=[number]&param_text=[text]&secret=">
                        </div>
                        <p class="help-block col-md-4">Must include <b>[text]</b> &amp; <b>[number]</b>, it will be
                            replaced.
                        </p>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">You can use WhatsApp in here too. <a
                            href="https://sms.freeispradius.com" target="_blank">Free Server</a></small>
                </div>



                               <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <a class="btn btn-success btn-xs" style="color: black;" href="javascript:testEmail()">Test
                            Email</a>
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Email Notification')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">SMTP Host : port</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="smtp_host" name="smtp_host"
                                value="{$_c['smtp_host']}" placeholder="smtp.host.tld">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" id="smtp_port" name="smtp_port"
                                value="{$_c['smtp_port']}" placeholder="465 587 port">
                        </div>
                        <p class="help-block col-md-4">Empty this to use internal mail() PHP</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">SMTP username</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="smtp_user" name="smtp_user"
                                value="{$_c['smtp_user']}" placeholder="user@host.tld">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">SMTP Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="smtp_pass" name="smtp_pass"
                                value="{$_c['smtp_pass']}" onmouseleave="this.type = 'password'"
                                onmouseenter="this.type = 'text'">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">SMTP Security</label>
                        <div class="col-md-6">
                            <select name="smtp_ssltls" id="smtp_ssltls" class="form-control">
                                <option value="" {if $_c['smtp_ssltls']=='' }selected="selected" {/if}>Not Secure
                                </option>
                                <option value="ssl" {if $_c['smtp_ssltls']=='ssl' }selected="selected" {/if}>SSL
                                </option>
                                <option value="tls" {if $_c['smtp_ssltls']=='tls' }selected="selected" {/if}>TLS
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">UPPERCASE lowercase RaNdoM</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Mail From</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="mail_from" name="mail_from"
                                value="{$_c['mail_from']}" placeholder="noreply@host.tld">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Mail Reply To</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="mail_reply_to" name="mail_reply_to"
                                value="{$_c['mail_reply_to']}" placeholder="support@host.tld">
                        </div>
                        <p class="help-block col-md-4">Customer will reply email to this address, empty if you want to
                            use From Address</p>
                    </div>
                </div>



<div class="panel-heading">
    <div class="btn-group pull-right">
        <button class="btn btn-primary btn-xs" title="save" type="submit">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
        </button>
    </div>
    {Lang::T('User Notification')}
</div>
<div class="panel-body">
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Expired Notification')}</label>
        <div class="col-md-6">
            <select name="user_notification_expired" id="user_notification_expired" class="form-control">
                <option value="none" {if $_c['user_notification_expired'] == 'none'}selected="selected"{/if}>None</option>
                <option value="wa" {if $_c['user_notification_expired'] == 'wa'}selected="selected"{/if}>WhatsApp</option>
                <option value="sms" {if $_c['user_notification_expired'] == 'sms'}selected="selected"{/if}>SMS</option>
                <option value="email" {if $_c['user_notification_expired'] == 'email'}selected="selected"{/if}>Email</option>
                <option value="both" {if $_c['user_notification_expired'] == 'both'}selected="selected"{/if}>WhatsApp and SMS</option>
                <option value="sms_email" {if $_c['user_notification_expired'] == 'sms_email'}selected="selected"{/if}>SMS and Email</option>
                <option value="email_wa" {if $_c['user_notification_expired'] == 'email_wa'}selected="selected"{/if}>Email and WhatsApp</option>
                <option value="all" {if $_c['user_notification_expired'] == 'all'}selected="selected"{/if}>All</option>
            </select>
        </div>
        <p class="help-block col-md-4">{Lang::T('User will get notification when package expired')}</p>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Payment Notification')}</label>
        <div class="col-md-6">
            <select name="user_notification_payment" id="user_notification_payment" class="form-control">
                <option value="none" {if $_c['user_notification_payment'] == 'none'}selected="selected"{/if}>None</option>
                <option value="wa" {if $_c['user_notification_payment'] == 'wa'}selected="selected"{/if}>WhatsApp</option>
                <option value="sms" {if $_c['user_notification_payment'] == 'sms'}selected="selected"{/if}>SMS</option>
                <option value="email" {if $_c['user_notification_payment'] == 'email'}selected="selected"{/if}>Email</option>
                <option value="both" {if $_c['user_notification_payment'] == 'both'}selected="selected"{/if}>WhatsApp and SMS</option>
                <option value="sms_email" {if $_c['user_notification_payment'] == 'sms_email'}selected="selected"{/if}>SMS and Email</option>
                <option value="email_wa" {if $_c['user_notification_payment'] == 'email_wa'}selected="selected"{/if}>Email and WhatsApp</option>
                <option value="all" {if $_c['user_notification_payment'] == 'all'}selected="selected"{/if}>All</option>
            </select>
        </div>
        <p class="help-block col-md-4">{Lang::T('User will get invoice notification when buying a package or refilling a package')}</p>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Reminder Notification')}</label>
        <div class="col-md-6">
            <select name="user_notification_reminder" id="user_notification_reminder" class="form-control">
                <option value="none" {if $_c['user_notification_reminder'] == 'none'}selected="selected"{/if}>None</option>
                <option value="wa" {if $_c['user_notification_reminder'] == 'wa'}selected="selected"{/if}>WhatsApp</option>
                <option value="sms" {if $_c['user_notification_reminder'] == 'sms'}selected="selected"{/if}>SMS</option>
                <option value="email" {if $_c['user_notification_reminder'] == 'email'}selected="selected"{/if}>Email</option>
                <option value="both" {if $_c['user_notification_reminder'] == 'both'}selected="selected"{/if}>WhatsApp and SMS</option>
                <option value="sms_email" {if $_c['user_notification_reminder'] == 'sms_email'}selected="selected"{/if}>SMS and Email</option>
                <option value="email_wa" {if $_c['user_notification_reminder'] == 'email_wa'}selected="selected"{/if}>Email and WhatsApp</option>
                <option value="all" {if $_c['user_notification_reminder'] == 'all'}selected="selected"{/if}>All</option>
            </select>
        </div>
    </div>
</div>


                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Tawk.to Chat Widget')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">https://tawk.to/chat/</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="tawkto" name="tawkto" value="{$_c['tawkto']}"
                                placeholder="62f1ca7037898912e961f5/1ga07df">
                        </div>
                        <p class="help-block col-md-4">From Direct Chat Link.</p>
                    </div>
                    <label class="col-md-2"></label>
                    <p class="col-md-6 help-block">/ip hotspot walled-garden<br>
                        add dst-host=tawk.to<br>
                        add dst-host=*.tawk.to</p>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    API Key
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Access Token</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="note" name="note"
                                rows="3">{Lang::htmlspecialchars($_c['note'])}</textarea>
                                                     <span class="help-block">{Lang::T('You can use html tag')}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Proxy')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Proxy Server')}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="http_proxy" name="http_proxy"
                                value="{$_c['http_proxy']}" placeholder="127.0.0.1:3128">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Proxy Server Login')}</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="http_proxyauth" name="http_proxyauth"
                                autocomplete="off" value="{$_c['http_proxyauth']}" placeholder="username:password"
                                onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'">
                        </div>
                    </div>
                </div>

<!-- New panel for Hashback API Key section -->
<div class="panel-heading">
    <div class="btn-group pull-right">
        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
    </div>
    {Lang::T('Hashback API Key')}
</div>
<div class="panel-body">
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Hashback API Key')}</label>
        <div class="col-md-6">
            <input type="text" name="hashback_api_key" id="hashback_api_key" class="form-control" value="{$_c['hashback_api_key']|escape:'html'}">
        </div>
        <p class="help-block col-md-4">{Lang::T('Enter your Hashback API Key here')}</p>
    </div>
</div>



   <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <button class="btn btn-primary btn-xs" title="save" type="submit"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span></button>
                    </div>
                    {Lang::T('Miscellaneous')}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('OTP Required')}</label>
                        <div class="col-md-6">
                            <select name="allow_phone_otp" id="allow_phone_otp" class="form-control">
                                <option value="no" {if $_c['allow_phone_otp']=='no' }selected="selected" {/if}>
                                    No</option>
                                <option value="yes" {if $_c['allow_phone_otp']=='yes' }selected="selected" {/if}>Yes
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">{Lang::T('OTP is required when user want to change phone
                            number')}</p>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('OTP Method')}</label>
                        <div class="col-md-6">
                            <select name="phone_otp_type" id="phone_otp_type" class="form-control">
                                <option value="sms" {if $_c['phone_otp_type']=='sms' }selected="selected" {/if}>
                                    {Lang::T('SMS')}
                                <option value="whatsapp" {if $_c['phone_otp_type']=='whatsapp' }selected="selected"
                                    {/if}> {Lang::T('WhatsApp')}
                                <option value="both" {if $_c['phone_otp_type']=='both' }selected="selected" {/if}>
                                    {Lang::T('SMS and WhatsApp')}
                                </option>
                            </select>
                        </div>
                        <p class="help-block col-md-4">{Lang::T('The method which OTP will be sent to user')}</p>
                    </div>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">{Lang::T('Save
                        Changes')}</button>
                </div>
            </div>

            <pre>/ip hotspot walled-garden
add dst-host={$_domain}
add dst-host=*.{$_domain}</pre>

            <pre>
# Expired Cronjob Every 5 Minutes
*/5 * * * * cd {$dir} && {$php} cron.php

# Expired Cronjob Every 1 Hour
0 * * * * cd {$dir} && {$php} cron.php
</pre>
            <pre>
# Reminder Cronjob Every 7 AM
0 7 * * * cd {$dir} && {$php} cron_reminder.php
</pre>
        </div>
    </div>
</form>

<script>
    function testWa() {
        var target = prompt("Phone number\nSave First before Test", "");
        if (target != null) {
            window.location.href = '{$_url}settings/app&testWa='+target;
        }
    }
    function testSms() {
        var target = prompt("Phone number\nSave First before Test", "");
        if (target != null) {
            window.location.href = '{$_url}settings/app&testSms='+target;
        }
    }
    function testTg() {
        window.location.href = '{$_url}settings/app&testTg=test';
    }

        function testEmail() {
        var target = prompt("Email\nSave First before Test", "");
        if (target != null) {
            window.location.href = '{$_url}settings/app&testEmail=' + target;
        }
    }
</script>



<div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="tutorialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tutorialModalLabel">Tutorial Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/kWP_ca0VxCI?si=ixB8gXEILXdeCGV2" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{include file="sections/footer.tpl"}