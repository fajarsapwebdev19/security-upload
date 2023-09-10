<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="mt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Security Upload File</div>
                        <div class="card-body">
                            <?php
                                session_start();

                                // Fungsi untuk menghasilkan token CSRF yang unik
                                function generateCSRFToken() {
                                    return bin2hex(random_bytes(32));
                                }

                                // Inisialisasi token CSRF saat sesi dimulai
                                if (!isset($_SESSION['csrf_token'])) {
                                    $_SESSION['csrf_token'] = generateCSRFToken();
                                }

                                // Token CSRF
                                $csrfToken = $_SESSION['csrf_token'];
                                
                                if(isset($_SESSION['msg']))
                                {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                            <form action="proses-upload.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="">File</label>
                                    <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>">
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="upload" class="btn btn-xl btn-success">
                                        Upload
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>