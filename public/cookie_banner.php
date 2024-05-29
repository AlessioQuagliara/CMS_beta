<style>
        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1080;
        }
    </style>
<div class="toast-container">
        <div id="cookieToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="toast-body">
            Noi e terze parti selezionate utilizziamo cookie o tecnologie simili per finalità tecniche e, con il tuo consenso, anche per le finalità di misurazione.
                <div class="mt-2 pt-2 border-top">
                    <button id="acceptCookies" type="button" class="btn btn-primary btn-sm">Accetta</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Rifiuto</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Controlla se il cookie esiste
            if (!getCookie('cookiesAccepted')) {
                var toastEl = document.getElementById('cookieToast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();

                document.getElementById('acceptCookies').addEventListener('click', function() {
                    setCookie('cookiesAccepted', 'true', 365);
                    toast.hide();
                });

                toastEl.querySelector('[data-bs-dismiss="toast"]').addEventListener('click', function() {
                    toast.hide();
                });
            }
        });

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
    </script>