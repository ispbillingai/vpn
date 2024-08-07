<script src="<?= site_url('themes/focus2/vendor/toastr/js/toastr.min.js'); ?>"></script>
<script src="<?= site_url('themes/focus2/vendor/timeago/jquery.timeago.js'); ?>"></script>
<script src="<?= site_url('themes/focus2/vendor/timeago/locales/jquery.timeago.'.langJS().'.js'); ?>"></script>
<script>
    "use strict";
    $(document).ready(function () {
        let time_ago  = document.getElementsByClassName("timeAgo");
        for (let i = 0; i < time_ago.length; i++) {
            time_ago[i].innerText = jQuery.timeago(time_ago[i].innerText)
        }
        let loader = document.getElementsByClassName('sk-three-bounce');
        localStorage.getItem("theme") === "dark" ? loader[0].style.backgroundColor = "#2A2C32" : loader[0].style.backgroundColor = "#fff";
    });

    window.addEventListener('DOMContentLoaded', (event) => {		
        let checkbox = document.querySelector("input");	
        let body = document.querySelector("body");
        let theme = localStorage.getItem("theme");
        if(theme === "dark"){
            checkbox.checked = true;
        }
        checkbox.addEventListener('change', (event) => {
            event.target.checked ? body.setAttribute('data-theme-version', "dark") : body.removeAttribute("data-theme-version");
            event.target.checked ? localStorage.setItem("theme", "dark") : localStorage.setItem("theme", "");
            console.log("oi")
        });
    });
</script>
<div class="footer">
    <div class="copyright">
        <p>Copyright © Designed by <a href="https://quixkit.com/" target="_blank">Quixkit</a> &amp; Developed by <a href="https://eduardofiorini.com/" target="_blank">Eduardo Fiorini</a> - WebGuard v<?=version()?> </p>
    </div>
</div>
</div>
</body>
</html>