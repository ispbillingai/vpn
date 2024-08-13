{include file="sections/header.tpl"}
<!-- voucher -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-hovered mb20 panel-primary">
            <div class="panel-heading">
                {if in_array($_admin['user_type'],['SuperAdmin','Admin'])}
                    <div class="btn-group pull-right">
                        <a class="btn btn-danger btn-xs" title="Remove used Voucher" href="{$_url}prepaid/remove-voucher"
                            onclick="return confirm('Delete all used voucher code?')"><span
                                class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete All</a>
                    </div>
                {/if}
                {Lang::T('Prepaid Vouchers')}
            </div>
            <div class="panel-body">
                <div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">
                    <div class="col-md-8">
                        <form id="site-search" method="post" action="{$_url}prepaid/voucher/">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-search"></span>
                                </div>
                                <input type="text" name="code" class="form-control"
                                    placeholder="{Lang::T('Search by Code Voucher')}..." value="{$_code}">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">{Lang::T('Search')}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group btn-group-justified" role="group">
                            <div class="btn-group" role="group">
                                <a href="{$_url}prepaid/add-voucher" class="btn btn-primary btn-block"><i
                                        class="ion ion-android-add"> </i> {Lang::T('Add Vouchers')}</a>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{$_url}prepaid/print-voucher" target="print_voucher" class="btn btn-info"><i
                                        class="ion ion-android-print"> </i> Print</a>
                            </div>
                        </div>
                    </div>&nbsp;
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>{Lang::T('Type')}</th>
                                <th>{Lang::T('Routers')}</th>
                                <th>{Lang::T('Plan Name')}</th>
                                <th>{Lang::T('Code Voucher')}</th>
                                <th>{Lang::T('Status Voucher')}</th>
                                <th>{Lang::T('Customer')}</th>
                                <th>{Lang::T('Manage')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $d as $ds}
                                <tr {if $ds['status'] eq '1'}class="danger" {/if}>
                                    <td>{$ds['id']}</td>
                                    <td>{$ds['type']}</td>
                                    <td>{$ds['routers']}</td>
                                    <td>{$ds['name_plan']}</td>
                                    <td width="10px"><input type="password" value="{$ds['code']}"
                                            style="width:120px;border: 0px; text-align: right;" class="pull-right"
                                            onmouseleave="this.type = 'password'" onmouseenter="this.type = 'text'"
                                            onclick="this.select()"></td>
                                    <td align="center">{if $ds['status'] eq '0'} <label class="btn-tag btn-tag-success">Not
                                            Use</label> {else} <label class="btn-tag btn-tag-danger">Used</label>
                                        {/if}</td>
                                    <td align="center">{if $ds['user'] eq '0'} - {else}<a href="{$_url}customers/viewu/{$ds['user']}">{$ds['user']}</a>{/if}</td>
                                    <td>
                                        <a href="{$_url}prepaid/voucher-delete/{$ds['id']}" id="{$ds['id']}"
                                            class="btn btn-danger btn-xs"
                                            onclick="return confirm('{Lang::T('Delete')}?')"><i class="glyphicon glyphicon-trash"></i></a>
                                    </td>
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


{include file="sections/footer.tpl"}