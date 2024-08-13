{include file="sections/header.tpl"}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<style>
    .black-option, .select2-selection__choice, .select2-results__option {
        color: black !important;
    }
</style>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-primary panel-hovered panel-stacked mb30">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{Lang::T('Send Bulk Messages')}</span>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-left: auto;">
                        {Lang::T('Need Help?')}
                    </button>
                </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#bulkSend">{Lang::T('Bulk Send')}</a></li>
                    <li><a data-toggle="tab" href="#routerSpecific">{Lang::T('Router Specific')}</a></li>
                </ul>

                <div class="tab-content">
                    <div id="bulkSend" class="tab-pane fade in active">
                        <form class="form-horizontal" method="post" role="form" id="bulkMessageForm" action="">
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Group')}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="group" id="group">
                                        <option value="all" selected>{Lang::T('All Customers')}</option>
                                        <option value="new">{Lang::T('New Customers')}</option>
                                        <option value="expired">{Lang::T('Expired Customers')}</option>
                                        <option value="active">{Lang::T('Active Customers')}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Send Via')}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="via" id="via">
                                        <option value="sms" selected>{Lang::T('SMS')}</option>
                                        <option value="wa">{Lang::T('WhatsApp')}</option>
                                        <option value="both">{Lang::T('SMS and WhatsApp')}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Message per time')}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="batch" id="batch">
                                        <option value="5">{Lang::T('5 Messages')}</option>
                                        <option value="10" selected>{Lang::T('10 Messages')}</option>
                                        <option value="15">{Lang::T('15 Messages')}</option>
                                        <option value="20">{Lang::T('20 Messages')}</option>
                                        <option value="20">{Lang::T('30 Messages')}</option>
                                        <option value="20">{Lang::T('40 Messages')}</option>
                                        <option value="20">{Lang::T('50 Messages')}</option>
                                        <option value="20">{Lang::T('60 Messages')}</option>
                                    </select>{Lang::T('Use 20 and above if you are sending to all customers to avoid server time out')}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Delay')}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="delay" id="delay">
                                        <option value="0" selected>{Lang::T('No Delay')}</option>
                                        <option value="5">{Lang::T('5 Seconds')}</option>
                                        <option value="10">{Lang::T('10 Seconds')}</option>
                                        <option value="15">{Lang::T('15 Seconds')}</option>
                                        <option value="20">{Lang::T('20 Seconds')}</option>
                                    </select>{Lang::T('Use at least 5 secs if you are sending to all customers to avoid being banned by your message provider')}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Message')}</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="message" placeholder="{Lang::T('Compose your message...')}" rows="5"></textarea>
                                    <input name="test" type="checkbox"> {Lang::T('Testing [if checked no real message is sent]')}
                                </div>
                                <p class="help-block col-md-4">
                                    {Lang::T('Use placeholders:')}<br>
                                    <b>[[name]]</b> - {Lang::T('Customer Name')}<br>
                                    <b>[[user_name]]</b> - {Lang::T('Customer Username')}<br>
                                    <b>[[phone]]</b> - {Lang::T('Customer Phone')}<br>
                                    <b>[[company_name]]</b> - {Lang::T('Your Company Name')}
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit" name="send" value="now">
                                        {Lang::T('Send Message')}
                                    </button>
                                    <a href="{$_url}dashboard" class="btn btn-default">{Lang::T('Cancel')}</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="routerSpecific" class="tab-pane fade">
                        <form class="form-horizontal" method="post" role="form" action="{$_url}settings/specific-post">
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Send to')}</label>
                                <div class="col-md-6">
                                    <label><input type="radio" id="All" name="type" value="All" checked>  {Lang::T('All users')}</label>
                                    <label><input type="radio" id="Spec" name="type" value="Spec">  {Lang::T('Specific users')}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Routers')}</label>
                                <div class="col-md-6">
                                    <select id="server" name="server" class="form-control select2">
                                        <option value=''>{Lang::T('Select routers')}</option>
                                        {foreach $r as $router}
                                            <option value='{$router->id}'>{$router->name}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="selectAccountGroup">
                                <label class="col-md-2 control-label">{Lang::T('Select User(s)')}</label>
                                <div class="col-md-6">
                                    <select id="personSelect" class="form-control select2" name="id_customer[]" multiple style="width: 100%" data-placeholder="{Lang::T('Select Customer')}...">
                                        <option data-router="" value="" class="user-option black-option"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{Lang::T('Message')}</label>
                                <div class="col-md-6">
                                    <select id="type" name="msgtype" class="form-control select2">
                                        <option class="plan-option" data-type="" value='downtime_alert'>{Lang::T('Downtime alert')}</option>
                                        <option class="plan-option" data-type="" value='discount_alert'>{Lang::T('Discount/Offer message')}</option>
                                        <option class="plan-option" data-type="" value='custom_message'>{Lang::T('Custom Message')}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <button class="btn btn-success" type="submit">{Lang::T('Send Now')}</button>
                                    {Lang::T('Or')} <a href="{$_url}settings/specific">{Lang::T('Cancel')}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{if $batchStatus}
<p>
    <span class="label label-success">{Lang::T('Total SMS Sent')}: {$totalSMSSent}</span>
    <span class="label label-danger">{Lang::T('Total SMS Failed')}: {$totalSMSFailed}</span>
    <span class="label label-success">{Lang::T('Total WhatsApp Sent')}: {$totalWhatsappSent}</span>
    <span class="label label-danger">{Lang::T('Total WhatsApp Failed')}: {$totalWhatsappFailed}</span>
</p>
{/if}
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{Lang::T('Message Results')}</h3>
    </div>
    <div class="box-body">
        <table id="messageResultsTable" class="table table-bordered table-striped table-condensed">
            <thead>
                <tr>
                    <th>{Lang::T('Name')}</th>
                    <th>{Lang::T('Phone')}</th>
                    <th>{Lang::T('Message')}</th>
                    <th>{Lang::T('Status')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach $batchStatus as $customer}
                <tr>
                    <td>{$customer.name}</td>
                    <td>{$customer.phone}</td>
                    <td>{$customer.message}</td>
                    <td>{$customer.status}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function () {
        $j('#messageResultsTable').DataTable();

        // Router Specific form script
        $j('#selectAccountGroup').hide();
        
        $j('input[type="radio"]').change(function() {
            var selectedType = $j(this).val();
            if (selectedType === "All") {
                $j('#selectAccountGroup').hide();
            } else {
                $j('#selectAccountGroup').show();
            }
        });
        
        $j('#personSelect').select2();

        $j('#server').change(function() {
            var selectedRouterId = $j(this).val();
            $j.ajax({
                url: '{$_url}plugin/finduser&router=' + selectedRouterId,
                type: "GET",
                data: { router_id: selectedRouterId },
                success: function(response){
                    var data = JSON.parse(response);
                    $j('#personSelect').empty(); 
                    data.forEach(function(user) {
                        var usernameWithEmail = user.username + ' - ' + user.email;
                        $j('#personSelect').append($j('<option>', {
                            value: user.id,
                            text: usernameWithEmail,
                            class: 'black-option'
                        }));
                    });
                    $j('#personSelect').trigger('change.select2');
                },
                error: function(xhr, status, error) {
                    console.log('failed');
                }
            });
        });
    });
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
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/M91aZf1wrEw?si=f3cxhNtD6wDbMBwz" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{include file="sections/footer.tpl"}