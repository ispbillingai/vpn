{include file="sections/user-header.tpl"}

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">{Lang::T('Create VPN')}</h3>
            </div>
            <div class="box-body">
                {if $msg}
                <div class="alert alert-danger">{$msg}</div>
                {/if}
                <form method="post" action="{$_url}vpn/create-vpn" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{Lang::T('Router Name')}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="vpn_name" name="vpn_name" required placeholder="{Lang::T('Enter Router Name for Reference')}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{Lang::T('VPN Username')}</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="vpn_user" name="vpn_user" required placeholder="{Lang::T('Enter VPN Username')}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">{Lang::T('VPN Password')}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="vpn_pass" name="vpn_pass" required placeholder="{Lang::T('Enter VPN Password')}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary">{Lang::T('Create VPN')}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{include file="sections/user-footer.tpl"}
