{include file="sections/header.tpl"}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-hovered mb20 panel-primary">
            <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                <span>{Lang::T('Active Packages')}</span>
                {if in_array($_admin['user_type'],['SuperAdmin','Admin'])}
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-right: 10px;">
                            {Lang::T('Need Help?')}
                        </button>
                        <a class="btn btn-primary btn-xs" title="sync" href="{$_url}prepaid/sync" onclick="return confirm('This will sync/send Customer active plan to Mikrotik?')">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Sync
                        </a>
                        <a class="btn btn-info btn-xs" title="export" href="{$_url}customers/csv-prepaid" onclick="return confirm('This will export to CSV?')">
                            <span class="glyphicon glyphicon-download" aria-hidden="true"></span> CSV
                        </a>
                    </div>
                {/if}
            </div>

            <ul class="nav nav-tabs nav-justified">
                <li class="{if $filter == 'active_packages'}active{/if}">
                    <a href="{$_url}prepaid/active_packages" class="bg-primary">
                        <i class="fa fa-users"></i> {Lang::T('All Active')}
                    </a>
                </li>
                <li class="{if $filter == 'active_hotspot'}active{/if}">
                    <a href="{$_url}prepaid/active_hotspot" class="bg-warning">
                        <i class="fa fa-wifi"></i> {Lang::T('Hotspot')}
                    </a>
                </li>
                <li class="{if $filter == 'active_static'}active{/if}">
                    <a href="{$_url}prepaid/active_static" class="bg-info">
                        <i class="fa fa-desktop"></i> {Lang::T('Static')}
                    </a>
                </li>
                <li class="{if $filter == 'active_pppoe'}active{/if}">
                    <a href="{$_url}prepaid/active_pppoe" class="bg-purple">
                        <i class="fa fa-exchange"></i> {Lang::T('PPPoE')}
                    </a>
                </li>
            </ul>

            <div class="panel-body">
                <div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">
                    <div class="col-md-8">
                        <form id="site-search" method="post" action="{$_url}prepaid/active_packages">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-search"></span>
                                </div>
                                <input type="text" name="search" class="form-control" placeholder="{Lang::T('Search by Username')}..." value="{$search}">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">{Lang::T('Search')}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <a href="{$_url}prepaid/recharge" class="btn btn-primary btn-block">
                            <i class="ion ion-android-add"> </i> {Lang::T('Recharge Account')}
                        </a>
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
                                <th>{Lang::T('Status')}</th>
                                <th>{Lang::T('Last Seen')}</th>
                                <th>{Lang::T('Manage')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $d as $ds}
                                <tr {if $ds['status']=='off'}class="danger" {/if}>
                                    <td><a href="{$_url}customers/viewu/{$ds['username']}">{$ds['username']}</a></td>
                                    <td>{$ds['namebp']}</td>
                                    <td>{$ds['type']}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['recharged_on'], $ds['recharged_time'])}</td>
                                    <td>{Lang::dateAndTimeFormat($ds['expiration'], $ds['time'])}</td>
                                    <td>{$ds['method']}</td>
                                    <td>{$ds['routers']}</td>
                                    <td>
                                        <span class="label {if $ds['state'] == 'Online'}label-success{else}label-danger{/if}">
                                            {$ds['state']}
                                        </span>
                                    </td>
                                    <td>
                                        {if $ds['state'] == 'Online'}
                                            <span class="label label-success">{Lang::T('Currently Online')}</span>
                                        {else}
                                            <span class="label label-danger">{Lang::dateAndTimeFormat($ds['last_seen'], '')}</span>
                                        {/if}
                                    </td>
                                    <td>
                                        <a href="{$_url}prepaid/edit/{$ds['id']}" class="btn btn-warning btn-xs">{Lang::T('Edit')}</a>
                                        {if in_array($_admin['user_type'],['SuperAdmin','Admin'])}
                                            <a href="{$_url}prepaid/delete/{$ds['id']}" id="{$ds['id']}" onclick="return confirm('{Lang::T('Delete')}?')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                                        {/if}
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
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/8sHAiUXxH9w?si=KWoO8w_-dSFWuJoL" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{include file="sections/footer.tpl"}
