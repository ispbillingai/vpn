<!-- app/Views/themes/backend/focus2/form/vpn/list.php -->

<!--Content Body-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4><i class="<?= $title['icon'] ?? '' ?>"></i> <?= $title['module'] ?? '' ?></h4>
                    <span class="ml-1"><?= $title['page'] ?? '' ?></span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <?php foreach ($breadcrumb ?? [] as $item) : ?>
                        <?php if (!$item['active']) : ?>
                            <li class="breadcrumb-item"><a href="<?= site_url($item['route']) ?>"><?= $item['title'] ?></a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item active"><?= $item['title'] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-sm-6">
                            <h4 class="card-title"><?= $title['page'] ?? '' ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id='table-grid' class="table table-striped nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>VPN Name</th>
                                        <!-- Add other headers as necessary -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vpns as $vpn): ?>
                                        <tr>
                                            <td><?= $vpn['name'] ?></td>
                                            <!-- Add other data as necessary -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
