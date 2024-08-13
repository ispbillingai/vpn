{include file="sections/user-header.tpl"}

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h4 class="card-title mb-0">{Lang::T('Mikrotik Configuration')}</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <strong>{Lang::T('Copy the following configuration and paste it into your Mikrotik RouterOS terminal:')}</strong>
                    </div>
                    <pre class="bg-dark text-white p-4 rounded">
                        {$config}
                    </pre>
                </div>
                <div class="card-footer text-center py-3">
                    <a href="{$_url}vpn/list-vpns" class="btn btn-lg btn-primary px-5">
                        <i class="fa fa-arrow-left mr-2"></i> {Lang::T('Back to VPN List')}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="sections/user-footer.tpl"}
