<?php
error_log('Loading create.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create VPN</title>
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Then load plugins that rely on jQuery -->
    <script src="<?= site_url('path/to/jquery.timeago.js') ?>"></script>
    <script src="<?= site_url('path/to/jquery.timeago.en.js') ?>"></script>
    <style>
        /* Add any necessary styling here */
        .loading-indicator {
            display: none;
            text-align: center;
            font-size: 20px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="loading-indicator">Loading...</div>

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
                            <form id="vpnForm" action="<?= site_url('vpn/store') ?>" method="post">
                                <div class="form-group">
                                    <label for="vpnName">VPN Name:</label>
                                    <input type="text" id="vpnName" name="vpnName" class="form-control" required>
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

    <script>
        $(document).ready(function () {
            console.log("Page loaded successfully");

            // Show loading indicator
            $(".loading-indicator").show();

            // Simulate data loading (this would be replaced with actual logic)
            setTimeout(function () {
                $(".loading-indicator").hide();
                console.log("Loading complete");
            }, 1000);

            // Attach event listener to the form
            $("#vpnForm").on("submit", function (e) {
                e.preventDefault(); // Prevent default form submission
                console.log("Form submission initiated");

                let formData = $(this).serialize();
                console.log("Form data:", formData);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    beforeSend: function () {
                        console.log("Submitting form...");
                    },
                    success: function (response) {
                        console.log("Form submission successful", response);
                        alert('VPN created successfully');
                        // Redirect or update the page as necessary
                    },
                    error: function (xhr, status, error) {
                        console.error("Form submission failed:", error);
                        alert('An error occurred while creating the VPN');
                    }
                });
            });
        });
    </script>
</body>
</html>
