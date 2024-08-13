{include file="sections/user-header.tpl"}

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3 class="card-title mb-0">{$_title}</h3>
                    <p class="mb-0 mt-2">Manage your remote access settings for each VPN.</p>
                </div>
                <div class="card-body p-4">
                    {if $vpns|@count > 0}
                        {foreach from=$vpns item=vpn}
                            <div class="mb-4">
                                <h5 class="font-weight-bold">{$vpn.vpn_name}</h5>
                                <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#config-{$vpn.id}" aria-expanded="false" aria-controls="config-{$vpn.id}">
                                    {Lang::T('Show Remote Access Details')}
                                </button>
                                <div class="collapse mt-3" id="config-{$vpn.id}">
                                    <div class="card card-body">
                                        <strong>{Lang::T('Winbox Access')}:</strong>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="winbox-address-{$vpn.id}" value="mikrotik.freeispradius.com:{$vpn.winbox_port}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('winbox-address-{$vpn.id}')">
                                                    <i class="fa fa-copy"></i> {Lang::T('Copy')}
                                                </button>
                                            </div>
                                        </div>
                                        <strong>{Lang::T('Web Access')}:</strong>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="web-address-{$vpn.id}" value="http://mikrotik.freeispradius.com:{$vpn.web_port}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('web-address-{$vpn.id}')">
                                                    <i class="fa fa-copy"></i> {Lang::T('Copy')}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        <div class="alert alert-warning text-center">
                            <strong>{Lang::T('No VPN accounts found.')}</strong>
                            <p>{Lang::T('Please create a VPN account to see remote access details.')}</p>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).value;
        var textarea = document.createElement("textarea");
        textarea.value = copyText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("Address copied to clipboard!");
    }
</script>

{include file="sections/user-footer.tpl"}
