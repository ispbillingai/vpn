{include file="sections/user-header.tpl"}
<!-- user-activation-list -->

<div class="row">
    <div class="col-sm-12">
        <div class="panel mb20 panel-hovered panel-primary">
           <div class="panel-heading">{Lang::T('List Activated Voucher')}</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>{Lang::T('Username')}</th>
                                <th>{Lang::T('Plan Name')}</th>
                                <th>{Lang::T('Plan Price')}</th>
                                <th>{Lang::T('Type')}</th>
                                <th>{Lang::T('Created On')}</th>
                                <th>{Lang::T('Expires On')}</th>
                                <th>{Lang::T('Method')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $d as $ds}
                                <tr>
                                    <td>{$ds['username']}</td>
                                    <td>{$ds['plan_name']}</td>
                                    <td>{Lang::moneyFormat($ds['price'])}</td>
                                    <td>{$ds['type']}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['recharged_on'],$ds['recharged_time'])}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['expiration'],$ds['time'])}</td>
                                    <td>{$ds['method']}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
                {$paginator['contents']}
            </div>
        </div>
    </div>
</div>


{include file="sections/user-footer.tpl"}