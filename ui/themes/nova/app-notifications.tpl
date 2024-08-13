{include file="sections/header.tpl"}

<form class="form-horizontal" method="post" role="form" action="{$_url}settings/notifications-post">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-primary panel-hovered panel-stacked mb30">
<div class="panel-heading">
    <div class="btn-group pull-right">
        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-right: 5px;">
            {Lang::T('Need Help?')}
        </button>
        <button class="btn btn-primary btn-xs" title="save" type="submit">
            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
        </button>
    </div>
    {Lang::T('User Notification')}
</div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Expired Notification Message')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="expired" name="expired"
                                placeholder="Hello [[name]], your internet package [[package]] has expired"
                                rows="3">{if $_json['expired']!=''}{Lang::htmlspecialchars($_json['expired'])}{else}Hello [[name]], your internet package [[package]] has expired.{/if}</textarea>
                        </div>
<p class="help-block col-md-4">
    <b>[[name]]</b> will be replaced with Customer Name.<br>
    <b>[[username]]</b> will be replaced with Username.<br>
    <b>[[package]]</b> will be replaced with Package name.<br>
    <b>[[price]]</b> will be replaced with Package price.<br>
    <b>[[username]]</b> will be replaced with Username.
</p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Reminder 7 days')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="reminder_7_day" name="reminder_7_day"
                                rows="3">{Lang::htmlspecialchars($_json['reminder_7_day'])}</textarea>
                        </div>
                        <p class="help-block col-md-4">
                             <b>[[name]]</b> will be replaced with Customer Name.
                                 <b>[[username]]</b> will be replaced with Username.<br>
                            <b>[[package]]</b> will be replaced with Package name.
                            <b>[[price]]</b> will be replaced with Package price.
                            <b>[[expired_date]]</b> will be replaced with Expiration date.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Reminder 3 days')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="reminder_3_day" name="reminder_3_day"
                                rows="3">{Lang::htmlspecialchars($_json['reminder_3_day'])}</textarea>
                        </div>
                        <p class="help-block col-md-4">
                                                  <b>[[name]]</b> will be replaced with Customer Name.
                                                      <b>[[username]]</b> will be replaced with Username.<br>
                            <b>[[package]]</b> will be replaced with Package name.
                            <b>[[price]]</b> will be replaced with Package price.
                            <b>[[expired_date]]</b> will be replaced with Expiration date.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Reminder 1 day')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="reminder_1_day" name="reminder_1_day"
                                rows="3">{Lang::htmlspecialchars($_json['reminder_1_day'])}</textarea>
                        </div>
                        <p class="help-block col-md-4">
                             <b>[[name]]</b> will be replaced with Customer Name.
                                 <b>[[username]]</b> will be replaced with Username.<br>
                            <b>[[package]]</b> will be replaced with Package name.
                            <b>[[price]]</b> will be replaced with Package price.
                            <b>[[expired_date]]</b> will be replaced with Expiration date.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Invoice Notification Payment')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="invoice_paid" name="invoice_paid"
                                placeholder="Hello [[name]], your internet package [[package]] has expired"
                                rows="20">{Lang::htmlspecialchars($_json['invoice_paid'])}</textarea>
                        </div>
                        <p class="col-md-4 help-block">
                            <b>[[company_name]]</b> Your Company Name at Settings.<br>
                            <b>[[address]]</b> Your Company Address at Settings.<br>
                            <b>[[phone]]</b> Your Company Phone at Settings.<br>
                            <b>[[invoice]]</b> invoice number.<br>
                            <b>[[date]]</b> Date invoice created.<br>
                            <b>[[payment_gateway]]</b> Payment gateway user paid from.<br>
                            <b>[[payment_channel]]</b> Payment channel user paid from.<br>
                            <b>[[type]]</b> is Hotspot/PPPOE.<br>
                            <b>[[plan_name]]</b> Internet Package.<br>
                            <b>[[plan_price]]</b> Internet Package Prices.<br>
                            <b>[[name]]</b> Receiver name.<br>
                            <b>[[user_name]]</b> Username internet.<br>
                            <b>[[user_password]]</b> User password.<br>
                            <b>[[expired_date]]</b> Expired datetime.<br>
                            <b>[[footer]]</b> Invoice Footer.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Balance Notification Payment')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="invoice_balance" name="invoice_balance"
                                placeholder="Hello [[name]], your internet package [[package]] has expired"
                                rows="20">{Lang::htmlspecialchars($_json['invoice_balance'])}</textarea>
                        </div>
                        <p class="col-md-4 help-block">
                            <b>[[company_name]]</b> Your Company Name at Settings.<br>
                            <b>[[address]]</b> Your Company Address at Settings.<br>
                            <b>[[phone]]</b> Your Company Phone at Settings.<br>
                            <b>[[invoice]]</b> invoice number.<br>
                            <b>[[date]]</b> Date invoice created.<br>
                            <b>[[payment_gateway]]</b> Payment gateway user paid from.<br>
                            <b>[[payment_channel]]</b> Payment channel user paid from.<br>
                            <b>[[type]]</b> is Hotspot/PPPOE.<br>
                            <b>[[plan_name]]</b> Internet Package.<br>
                            <b>[[plan_price]]</b> Internet Package Prices.<br>
                            <b>[[name]]</b> Receiver name.<br>
                            <b>[[user_name]]</b> Username internet.<br>
                            <b>[[user_password]]</b> User password.<br>
                            <b>[[trx_date]]</b> Transaction datetime.<br>
                            <b>[[balance_before]]</b> Balance Before.<br>
                            <b>[[balance]]</b> Balance After.<br>
                            <b>[[footer]]</b> Invoice Footer.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Send Balance')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="balance_send" name="balance_send"
                                rows="3">{if $_json['balance_send']}{Lang::htmlspecialchars($_json['balance_send'])}{else}{Lang::htmlspecialchars($_default['balance_send'])}{/if}</textarea>
                        </div>
                        <p class="col-md-4 help-block">
                            <b>[[name]]</b> Receiver name.<br>
                            <b>[[balance]]</b> how much balance have been send.<br>
                            <b>[[current_balance]]</b> Current Balance.
                        </p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Received Balance')}</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="balance_received" name="balance_received"
                                rows="3">{if $_json['balance_received']}{Lang::htmlspecialchars($_json['balance_received'])}{else}{Lang::htmlspecialchars($_default['balance_received'])}{/if}</textarea>
                        </div>
                        <p class="col-md-4 help-block">
                            <b>[[name]]</b> Sender name.<br>
                            <b>[[balance]]</b> how much balance have been received.<br>
                            <b>[[current_balance]]</b> Current Balance.
                        </p>
                    </div>
                </div>

<div class="panel-body">
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Account Created SMS Template')}</label>
        <div class="col-md-6">
            <textarea class="form-control" id="account_created_sms" name="account_created_sms"
                rows="3">{if $_json['account_created_sms']}{Lang::htmlspecialchars($_json['account_created_sms'])}{else}Hello [[name]], your account has been created.{/if}</textarea>
        </div>
        <p class="col-md-4 help-block">
            <b>[[name]]</b> will be replaced with Customer Name.<br>
            <b>[[user_password]]</b> will be replaced with user password to customer portal.<br>
            <b>[[user_name]]</b> will be replaced with username to customer portal.
        </p>
    </div>
</div>


<div class="panel-body">
    <div class="form-group">
        <label class="col-md-2 control-label">{Lang::T('Unknown Payments For Till Users')}</label>
        <div class="col-md-6">
            <textarea class="form-control" id="custom_message" name="custom_message"
                rows="3">{if $_json['custom_message']}{Lang::htmlspecialchars($_json['custom_message'])}{else} Dear [[phone]], we couldn't link your payment of [[amount]] to any account as the number wasn't used during registration. Please contact our support center to activate your account{/if}</textarea>
        </div>
        <p class="col-md-4 help-block">
            <b>[[amount]]</b> will be replaced with the payment amount.<br>
            <b>[[phone]]</b> will be replaced with the decoded phone number.
        </p>
    </div>
</div>


                
 
                       
                    </div>
                </div>


            </div>





            <div class="panel-body">
                <div class="form-group">
                    <button class="btn btn-success btn-block" type="submit">{Lang::T('Save Changes')}</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/_Aiel13F7CM?si=SDZMUrQeDO5BbMJy" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
{include file="sections/footer.tpl"}
