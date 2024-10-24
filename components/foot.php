</div>
<script src="<?= BASEURL ?>/assets/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            const validateButton = document.getElementById('validateCode'); // Ambil tombol validate

            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {
                        // Mengizinkan hanya angka untuk berpindah
                        if (event.keyCode >= 48 && event.keyCode <= 57) {
                            inputs[i].value = event.key;
                            if (i !== inputs.length - 1) {
                                inputs[i + 1].focus();
                            } else {
                                // Jika input terakhir, fokus ke tombol validate
                                validateButton.focus();
                            }
                            event.preventDefault();
                        } 
                        // Jika huruf, biarkan input tidak berpindah
                        else if (event.keyCode >= 65 && event.keyCode <= 90) {
                            event.preventDefault(); // Mencegah input huruf
                        }
                    }
                });
            }

            // Tambahkan listener untuk tombol validate
            validateButton.addEventListener('keydown', function(event) {
                if (event.key === "Backspace") {
                    // Fokus ke input terakhir saat Backspace ditekan
                    inputs[inputs.length - 1].focus();
                }
            });
        }
        OTPInput();



    });
</script>
</body>

</html>