{include file="sections/header.tpl"}
<!-- routers -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-hovered mb20 panel-primary">
            <div class="panel-heading">{Lang::T('Routers')}</div>
            <div class="panel-body">
                <div class="md-whiteframe-z1 mb20 text-center" style="padding: 15px">
                    <div class="col-md-8">
                        <form id="site-search" method="post" action="{$_url}routers/list/">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-search"></span>
                                </div>
                                <input type="text" name="name" class="form-control" placeholder="{Lang::T('Search by Name')}...">
                                <div class="input-group-btn">
                                    <button class="btn btn-success" type="submit">{Lang::T('Search')}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <a href="{$_url}routers/add" class="btn btn-primary btn-block waves-effect"><i class="ion ion-android-add"> </i> {Lang::T('New Router')}</a>
                    </div>&nbsp;
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>{Lang::T('Router Name')}</th>
                                <th>{Lang::T('Ip Address')}</th>
                                <th>{Lang::T('Username')}</th>
                                <th>{Lang::T('Description')}</th>
                                <th>{Lang::T('Status')}</th>
                                <th>{Lang::T('Ping Status')}</th>
                                <th>{Lang::T('Reboot')}</th>
                                <th>{Lang::T('Manage')}</th>
                                <th>ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $d as $ds}
                            <tr {if $ds['enabled'] != 1}class="danger" title="disabled"{/if}>
                                <td>{$ds['name']}</td>
                                <td>{$ds['ip_address']}</td>
                                <td>{$ds['username']}</td>
                                <td>{$ds['description']}</td>
                                <td>{if $ds['enabled'] == 1}Enabled{else}Disabled{/if}</td>
                                <td><span id="ping-status-{$ds['id']}" class="ping-status"><span class="label label-default">Checking...</span></span></td>
                                <td><a href="{$_url}routers/reboot/{$ds['id']}" class="btn btn-warning btn-xs reboot-router" data-id="{$ds['id']}">Reboot</a></td>
                                <td>
                                    <a href="{$_url}routers/edit/{$ds['id']}" class="btn btn-info btn-xs">{Lang::T('Edit')}</a>
                                    <a href="{$_url}routers/delete/{$ds['id']}" id="{$ds['id']}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                                <td>{$ds['id']}</td>
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

<script type="text/javascript">
$(document).ready(function() {
    function pingRouters() {
        $('.ping-status').each(function() {
            var routerId = $(this).attr('id').split('-')[2];
            var pingStatusElement = $(this);

            $.ajax({
                url: '{$_url}routers/ping/' + routerId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        pingStatusElement.html('<span class="label label-success">Active</span>');
                    } else {
                        pingStatusElement.html('<span class="label label-danger">Inactive</span>');
                    }
                },
                error: function() {
                    pingStatusElement.html('<span class="label label-danger">Inactive</span>');
                }
            });
        });
    }

    pingRouters();
    setInterval(pingRouters, 30000); // Ping every 30 seconds

    $('.reboot-router').click(function(e) {
        e.preventDefault();
        var routerId = $(this).data('id');
        var confirmReboot = confirm('Are you sure you want to reboot this router?');

        if (confirmReboot) {
            $.ajax({
                url: '{$_url}routers/reboot/' + routerId,
                type: 'POST',
                success: function(response) {
                    alert('Router reboot initiated successfully.');
                },
                error: function() {
                    alert('An error occurred while rebooting the router.');
                }
            });
        }
    });
});
</script>

{include file="sections/footer.tpl"}