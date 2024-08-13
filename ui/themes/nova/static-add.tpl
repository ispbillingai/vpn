{include file="sections/header.tpl"}

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-primary panel-hovered panel-stacked mb30">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{Lang::T('Add Static Plan')}</span>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tutorialModal" style="margin-left: auto;">
                        {Lang::T('Need Help?')}
                    </button>
                </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post" role="form" action="{$_url}services/static-add-post">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Status')}</label>
                        <div class="col-md-10">
                            <label class="radio-inline warning">
                                <input type="radio" checked name="enabled" value="1"> Enable
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="enabled" value="0"> Disable
                            </label>
                        </div>
                    </div>
                          <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Client Can Purchase')}</label>
                        <div class="col-md-10">
                            <label class="radio-inline warning">
                                <input type="radio" checked name="allow_purchase" value="yes"> Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="allow_purchase" value="no"> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Plan Name')}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name_plan" maxlength="40" name="name_plan">
                        </div>
                    </div>
                 <!-- Add Bandwidth Name dropdown -->
<div class="form-group">
                        <label class="col-md-2 control-label"><a
                                href="{$_url}bandwidth/add">{Lang::T('Bandwidth Name')}</a></label>
                        <div class="col-md-6">
                            <select id="id_bw" name="id_bw" class="form-control select2">
                                <option value="">{Lang::T('Select Bandwidth')}...</option>
                                {foreach $d as $ds}
                                    <option value="{$ds['id']}">{$ds['name_bw']}</option>
                                {/foreach}
        </select>
    </div>
</div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Plan Price')}</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">{$_c['currency_code']}</span>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Plan Validity')}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="validity" name="validity">
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" id="validity_unit" name="validity_unit">
                                <option value="Mins">{Lang::T('Mins')}</option>
                                <option value="Hrs">{Lang::T('Hrs')}</option>
                                <option value="Days">{Lang::T('Days')}</option>
                                <option value="Months">{Lang::T('Months')}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label"><a href="{$_url}routers/add">{Lang::T('Router Name')}</a></label>
                        <div class="col-md-6">
                            <select id="routers" name="routers" required class="form-control select2">
                              <option value=''>{Lang::T('Select Routers')}</option>
                                {foreach $r as $rs}
                                    <option value="{$rs['name']}">{$rs['name']}</option>
                                {/foreach}
                            </select>
                            <p class="help-block">{Lang::T('Cannot be change after saved')}</p>
                        </div>
                    </div>
                    <div class="form-group">
                                               <label class="col-md-2 control-label"><a href="{$_url}pool/add">{Lang::T('IP Pool')}</a></label>
                        <div class="col-md-6">
                            <select id="pool_name" name="pool_name" required class="form-control select2">
                                <option value=''>{Lang::T('Select Pool')}</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <button class="btn btn-primary" type="submit">{Lang::T('Save Changes')}</button>
                            Or <a href="{$_url}services/static">{Lang::T('Cancel')}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{if $_c['radius_enable']}
    {literal}
        <script>
            function isRadius(cek) {
                if (cek.checked) {
                    document.getElementById("routers").required = false;
                    document.getElementById("routers").disabled = true;
                    $.ajax({
                        url: "index.php?_route=autoload/pool",
                        data: "routers=radius",
                        cache: false,
                        success: function(msg) {
                            $("#pool_name").html(msg);
                        }
                    });
                    $.ajax({
                        url: "index.php?_route=autoload/pool",
                        data: "routers=radius",
                        cache: false,
                        success: function(msg) {
                            $("#pool_expired").html(msg);
                        }
                    });
                } else {
                    document.getElementById("routers").required = true;
                    document.getElementById("routers").disabled = false;
                }
            }
        </script>
    {/literal}
{/if}

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
