{include file="sections/header.tpl"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-hovered mb20 panel-primary">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <a class="btn btn-primary btn-xs" title="save" href="{$_url}prepaid/sync"
                        onclick="return confirm('This will sync/send Caustomer active plan to Mikrotik?')"><span
                            class="glyphicon glyphicon-refresh" aria-hidden="true"></span> sync</a>
               </div>{Lang::T('Prepaid Users')}
            </div>
            <div class="panel-body">
                <div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">
                    <div class="col-md-8">
                        <form id="site-search" method="post" action="{$_url}prepaid/list/">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-search"></span>
                                </div>
                                <input type="text" name="search" class="form-control"
                                    placeholder="{Lang::T('Search by Username')}..." value="{$search}">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">{Lang::T('Search')}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <a href="{$_url}prepaid/recharge" class="btn btn-primary btn-block"><i
                                 class="ion ion-android-add"> </i> {Lang::T('Recharge Account')}</a>
                    </div>&nbsp;
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                 <th>{Lang::T('Username')}</th>
                                <th>{Lang::T('Plan Name')}</th>
                                <th>{Lang::T('Type')}</th>
                                 <th>{Lang::T('Created On')}</th>
                                <th>{Lang::T('Expires On')}</th>
                                <th>{Lang::T('Method')}</th>
                                <th>{Lang::T('Routers')}</th>
                                <th>{Lang::T('Manage')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $d as $ds}
                                <tr {if $ds['status']=='off'}class="danger" {/if}>
                                    <td><a href="{$_url}customers/viewu/{$ds['username']}">{$ds['username']}</a></td>
                                    <td>{$ds['namebp']}</td>
                                    <td>{$ds['type']}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['recharged_on'],$ds['recharged_time'])}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['expiration'],$ds['time'])}</td>
                                    <td>{$ds['method']}</td>
                                    <td>{$ds['routers']}</td>
                                    <td>
                                        <a href="{$_url}prepaid/edit/{$ds['id']}"
                                           class="btn btn-warning btn-xs">{Lang::T('Edit')}</a>
                                        <a href="{$_url}prepaid/delete/{$ds['id']}" id="{$ds['id']}"
                                             class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                                            class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
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