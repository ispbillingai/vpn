<!DOCTYPE html>
<html lang="en">
    <head><meta charset="utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <link rel="icon" href="../themes/focus2/images/favicon.png" />
        <title>WebGuard - Installation</title>
        <link rel='stylesheet' type='text/css' href='../themes/focus2/vendor/bootstrap/dist/css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='../themes/focus2/icons/font-awesome/css/all.css' />
        <link rel='stylesheet' type='text/css' href='../assets/css/install.css' />

        <script type='text/javascript'  src='../themes/focus2/vendor/jquery/jquery.min.js'></script>
        <script type='text/javascript'  src='../themes/focus2/icons/font-awesome/js/all.js'></script>
        <script type='text/javascript'  src='../themes/focus2/vendor/jquery-validation/jquery.validate.min.js'></script>
        <script type='text/javascript'  src='../themes/focus2/vendor/jquery-validation/jquery.form.js'></script>
    </head>
    <body>
        <div class="install-box">

            <div class="card card-install">
                <div class="card-header text-center">                    
                    <h2> WebGuard Installation</h2>
                </div>
                <div class="card-body no-padding">
                    <div class="tab-container clearfix">
                        <div class="container">
                            <div class="row">
                                <div id="validation" class="tab-title col-sm-4 active"><i class="far fa-circle"></i><strong> Validation</strong></span></div>
                                <div id="configuration" class="tab-title col-sm-4"><i class="far fa-circle"></i><strong> Configuration</strong></div>
                                <div id="finished" class="tab-title col-sm-4"><i class="far fa-circle"></i><strong> Finished</strong></div>
                            </div>
                        </div>
                    </div>
                    <div id="alert-container">

                    </div>


                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="validation-tab">
                            <div class="section">
                                <p>1. Please configure your PHP settings to match following requirements:</p>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">PHP Settings</th>
                                                <th width="27%">Current Version</th>
                                                <th>Required Version</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>PHP Version</td>
                                                <td><?php echo $current_php_version??''; ?></td>
                                                <td><?php echo $php_version_required??''; ?>+</td>
                                                <td class="text-center">
                                                    <?php if ($php_version_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>2. Please make sure the extensions/settings listed below are installed/enabled:</p>
                                <hr />
                                <div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="25%">Extension/settings</th>
                                                <th width="27%">Current Settings</th>
                                                <th>Required Settings</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>MySQLi</td>
                                                <td> <?php if ($mysql_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysql_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GD</td>
                                                <td> <?php if ($gd_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($gd_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>cURL</td>
                                                <td> <?php if ($curl_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($curl_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>mbstring</td>
                                                <td> <?php if ($mbstring_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mbstring_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>intl</td>
                                                <td> <?php if ($intl_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($intl_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>json</td>
                                                <td> <?php if ($json_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($json_success) { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>mysqlnd</td>
                                                <td> <?php if ($mysqlnd_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($mysqlnd_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>xml</td>
                                                <td> <?php if ($xml_success??'') { ?>
                                                        On
                                                    <?php } else { ?>
                                                        Off
                                                    <?php } ?>
                                                </td>
                                                <td>On</td>
                                                <td class="text-center">
                                                    <?php if ($xml_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>date.timezone</td>
                                                <td> <?php
                                                    if ($timezone_success??'') {
                                                        echo $timezone_settings??'';
                                                    } else {
                                                        echo "Null";
                                                    }
                                                    ?>
                                                </td>
                                                <td>Timezone</td>
                                                <td class="text-center">
                                                    <?php if ($timezone_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>zlib.output_compression</td>
                                                <td> <?php if ($zlib_success??'') { ?>
                                                        Off
                                                    <?php } else { ?>
                                                        On
                                                    <?php } ?>
                                                </td>
                                                <td>Off</td>
                                                <td class="text-center">
                                                    <?php if ($zlib_success??'') { ?>
                                                        <i class="fas fa-check-circle"></i>
                                                    <?php } else { ?>
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="section">
                                <p>3. Please make sure you have set the <strong>writable</strong> permission on the following folders/files:</p>
                                <hr />
                                <div>
                                    <table>
                                        <tbody>
                                            <?php
                                            foreach ($writeable_directories??[] as $value) {
                                                ?>
                                                <tr>
                                                    <td style="width:87%;"><?php echo $value; ?></td>  
                                                    <td class="text-center">
                                                        <?php if (is_writeable(".." . $value)) { ?>
                                                            <i class="fas fa-check-circle"></i>
                                                            <?php
                                                        } else {
                                                            $all_requirement_success = false;
                                                            ?>
                                                            <i class="fas fa-times-circle text-danger"></i>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button <?php
                                if (!$all_requirement_success) {
                                    echo "disabled=disabled";
                                }
                                ?> class="btn btn-info form-next text-white">Next <i class="fas fa-arrow-right"></i></button>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane" id="configuration-tab">
                            <form name="config-form" id="config-form" action="process.php" method="post">

                                <div class="section clearfix">
                                    <p>1. Please enter your database connection details.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="host" class=" col-md-3">Database Host</label>
                                                <div class="col-md-9">
                                                    <input type="text" value="" id="host"  name="host" class="form-control" placeholder="Database Host (usually localhost)" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbuser" class=" col-md-3">Database User</label>
                                                <div class=" col-md-9">
                                                    <input id="dbuser" type="text" value="" name="dbuser" class="form-control" autocomplete="off" placeholder="Database user name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbpassword" class=" col-md-3">Password</label>
                                                <div class=" col-md-9">
                                                    <input id="dbpassword" type="password" value="" name="dbpassword" class="form-control" autocomplete="off" placeholder="Database user password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbname" class=" col-md-3">Database Name</label>
                                                <div class=" col-md-9">
                                                    <input id="dbname" type="text" value="" name="dbname" class="form-control" placeholder="Database Name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="dbprefix" class=" col-md-3">Database Prefix</label>
                                                <div class=" col-md-9">
                                                    <input id="dbprefix" type="text" value="wg_" name="dbprefix" class="form-control" placeholder="Database Prefix" maxlength="21" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>2. Please enter your account details for administration.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="first_name" class=" col-md-3">First Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" value=""  id="first_name"  name="first_name" class="form-control"  placeholder="Your first name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="last_name" class=" col-md-3">Last Name</label>
                                                <div class=" col-md-9">
                                                    <input type="text" value="" id="last_name"  name="last_name" class="form-control"  placeholder="Your last name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="email" class=" col-md-3">Email</label>
                                                <div class=" col-md-9">
                                                    <input id="email" type="text" value="" name="email" class="form-control" placeholder="Your email" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="password" class=" col-md-3">Password</label>
                                                <div class=" col-md-9">
                                                    <input id="password" type="password" value="" name="password" class="form-control" placeholder="Login password" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="section clearfix">
                                    <p>3. Please enter your item purchase code.</p>
                                    <hr />
                                    <div>
                                        <div class="form-group clearfix">
                                            <div class="row">
                                                <label for="purchase_code" class=" col-md-3">Item purchase code</label>
                                                <div class="col-md-9">
                                                    <input type="text" value=""  id="purchase_code"  name="purchase_code" class="form-control"  placeholder="Find in codecanyon item download section" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info form-next">
                                        <span class="loader text-white hide"><span> Please wait...</span></span>
                                        <span class="button-text text-white"><i class="fas fa-check"></i> Finish</span>
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="finished-tab">
                            <div class="section">
                                <div class="text-center">
                                    <div class="clearfix">Congratulation! You have successfully installed <b>WebGuard</b>.</div>
                                    <div style="color: #d73b3b;">
                                        Don't forget to delete the <b>install</b> directory in "<b>public/install</b>".
                                    </div>
                                </div>
                                <a class="go-to-login-page" href="<?php echo $dashboard_url??''; ?>">
                                    <div class="text-center">
                                        <div><i class="fas fa-desktop"></i> GO TO YOUR LOGIN PAGE</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    "use strict";
    let onFormSubmit = function ($form) {
        $form.find('[type="submit"]').attr('disabled', 'disabled').find(".loader").removeClass("hide");
        $form.find('[type="submit"]').find(".button-text").addClass("hide");
        $("#alert-container").html("");
    };
    let onSubmitSussess = function ($form) {
        $form.find('[type="submit"]').removeAttr('disabled').find(".loader").addClass("hide");
        $form.find('[type="submit"]').find(".button-text").removeClass("hide");
    };

    $(document).ready(function () {
        "use strict";
        let $preInstallationTab = $("#validation-tab"),
                $configurationTab = $("#configuration-tab");

        $('.form-next').on('click', function () {
            "use strict";
            if ($preInstallationTab.hasClass("active")) {
                $preInstallationTab.removeClass("active");
                $configurationTab.addClass("active");
                $("#validation").find("svg").remove();
                $("#validation").prepend('<i class="far fa-check-circle"></i>');
                $("#configuration").addClass("active");
                $("#host").focus();
            }
        });

        $('#config-form').on('submit', function () {
            "use strict";
            let $form = $(this);
            onFormSubmit($form);
            $form.ajaxSubmit({
                dataType: "json",
                success: function (result) {
                    onSubmitSussess($form, result);
                    if (result.success) {
                        $configurationTab.removeClass("active");
                        $("#configuration").find("svg").remove();
                        $("#configuration").prepend('<i class="far fa-check-circle"></i>');
                        $("#finished").find("svg").remove();
                        $("#finished").prepend('<i class="far fa-check-circle"></i>');
                        $("#finished").addClass("active");
                        $("#finished-tab").addClass("active");
                    } else {
                        $("#alert-container").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                    }
                }
            });
            return false;
        });
        
        //lowercase 
        //21 max characers 
        //only a-z letter and underscore allowed
        $('#dbprefix').on('keyup', function () {
            "use strict";
            let $dbPrefix = $('#dbprefix'),
                    replacedValue = $dbPrefix.val().replace(/[^a-z_]/g, '');

            $dbPrefix.val(replacedValue);
        });

        //add an underscore at the end
        $('#dbprefix').on('blur', function () {
            "use strict";
            let $dbPrefix = $('#dbprefix'),
                    dbPrefixValue = $dbPrefix.val();

            //allow only 20 characters fo prefix since the last one will be an underscore
            dbPrefixValue = dbPrefixValue.substring(0, 20);

            //add underscore if not exists
            let lastChar = dbPrefixValue.substr(dbPrefixValue.length - 1);
            if (lastChar !== "") {
                dbPrefixValue = dbPrefixValue + "";
            }
            $dbPrefix.val(dbPrefixValue);
        });

    });
</script>