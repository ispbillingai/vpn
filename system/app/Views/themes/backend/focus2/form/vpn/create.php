<?php
error_log('Loading simplified create.php');
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Create VPN</h4>
                    <span class="ml-1">Fill in the details below to create a new VPN.</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= site_url('vpn/store') ?>" method="post">
                            <div class="form-group">
                                <label for="vpnName">VPN Name:</label>
                                <input type="text" id="vpnName" name="vpnName" class="form-control">
                            </div>
                            <!-- Add other fields as necessary -->
                            <button type="submit" class="btn btn-primary">Create VPN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
