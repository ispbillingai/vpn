{include file="sections/user-header.tpl"}

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3 class="card-title mb-0">{Lang::T('Your VPN Accounts')}</h3>
                </div>
                <div class="card-body p-4">
                    {if $d|@count > 0}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3">{Lang::T('VPN Name')}</th>
                                        <th class="py-3">{Lang::T('Username')}</th>
                                        <th class="py-3">{Lang::T('Password')}</th>
                                        <th class="py-3">{Lang::T('Actions')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach from=$d item=vpn}
                                        <tr>
                                            <td class="align-middle">{$vpn.vpn_name}</td>
                                            <td class="align-middle">{$vpn.vpn_user}</td>
                                            <td class="align-middle">{$vpn.vpn_pass}</td>
                                            <td class="align-middle">
                                                <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#config-{$vpn.id}" aria-expanded="false" aria-controls="config-{$vpn.id}">
                                                    {Lang::T('Show Configuration')}
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                <div class="collapse" id="config-{$vpn.id}">
                                                    <div class="card card-body mt-3">
                                                        <strong>{Lang::T('RouterOS 6 Configuration')}:</strong>
                                                        <div class="input-group mb-3">
                                                            <pre id="config-text-6-{$vpn.id}" class="form-control" style="white-space: normal; word-wrap: break-word;" readonly>
/interface ovpn-client add connect-to=mikrotik.freeispradius.com name=freeispradius.com user={$vpn.vpn_user} password={$vpn.vpn_pass} profile=default comment=freeispradius.com_free_remote_access cipher=aes256 auth=sha1
                                                            </pre>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('config-text-6-{$vpn.id}')">{Lang::T('Copy')}</button>
                                                            </div>
                                                        </div>
                                                        <strong>{Lang::T('RouterOS 7 Configuration')}:</strong>
                                                        <div class="input-group mb-3">
                                                            <pre id="config-text-7-{$vpn.id}" class="form-control" style="white-space: normal; word-wrap: break-word;" readonly>
/interface ovpn-client add connect-to=mikrotik.freeispradius.com name=freeispradius.com user={$vpn.vpn_user} password={$vpn.vpn_pass} profile=default comment=freeispradius.com_free_remote_access cipher=aes256-cbc auth=sha1
                                                            </pre>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('config-text-7-{$vpn.id}')">{Lang::T('Copy')}</button>
                                                            </div>
                                                        </div>
                                                        <strong>{Lang::T('Add System User')}:</strong>
                                                        <div class="input-group mb-3">
                                                            <pre id="config-user-{$vpn.id}" class="form-control" style="white-space: normal; word-wrap: break-word;" readonly>
/user add name={$vpn.vpn_user} password={$vpn.vpn_pass} group=full comment=freeispradius.com_remote_access
                                                            </pre>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('config-user-{$vpn.id}')">{Lang::T('Copy')}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    {else}
                        <div class="alert alert-warning text-center">
                            <strong>{Lang::T('No VPN accounts found.')}</strong>
                            <p>{Lang::T('Create a VPN account to see it listed here.')}</p>
                        </div>
                    {/if}
                </div>
                <div class="card-footer text-center py-3">
                    <a href="{$_url}vpn/create-vpn" class="btn btn-lg btn-primary px-5">
                        <i class="fa fa-plus mr-2"></i> {Lang::T('Create New VPN')}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instructions Section -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-header bg-gradient-info text-white text-center py-4">
                    <h4 class="card-title mb-0">{Lang::T('Instructions for Connecting to Mikrotik')}</h4>
                </div>
                <div class="card-body p-4">
                    <ol class="list-group list-group-flush">
                        <li class="list-group-item">{Lang::T('Step 1: Log in to your Mikrotik router.')}</li>
                        <li class="list-group-item">{Lang::T('Step 2: Go to "New Terminal" from the main menu.')}</li>
                        <li class="list-group-item">{Lang::T('Step 3: Copy the appropriate configuration command from above based on your RouterOS version.')}</li>
                        <li class="list-group-item">{Lang::T('Step 4: Paste the command in the terminal and press Enter.')}</li>
                        <li class="list-group-item">{Lang::T('Step 5: Your VPN client and system user should now be configured and connected!')}</li>
                    </ol>
                    <div class="alert alert-success mt-4">
                        <strong>{Lang::T('Tip')}:</strong> {Lang::T('Always ensure that your router has the correct time and date settings to avoid issues with VPN connections.')}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).innerText;
        var textarea = document.createElement("textarea");
        textarea.value = copyText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert("{Lang::T('Configuration copied to clipboard!')}");
    }
</script>

{include file="sections/user-footer.tpl"}
