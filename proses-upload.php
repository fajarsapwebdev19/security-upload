<?php
session_start();
    // Token CSRF
    $csrfToken = $_SESSION['csrf_token'];

    $uploadDir = 'file/'; // Ganti dengan direktori penyimpanan yang sesuai
    $maxFileSize = 5 * 1024 * 1024; // Batasan ukuran file (dalam bytes), di sini 5 MB

    // Validasi ukuran file
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $csrfToken) {
        $_SESSION['msg'] = '<div class="alert alert-info"><div class="alert-message">Token Invalid</div></div>';
        header('location: ./');
    }
    else
    {
        if ($_FILES['file']['size'] > $maxFileSize) {
            $_SESSION['msg'] = '<div class="alert alert-info"><div class="alert-message">Ukuran File Max 5 MB</div></div>';
            header('location: ./');
        }
        else
        {
            // Validasi ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                $_SESSION['msg'] = '<div class="alert alert-danger"><div class="alert-message">Extensi File Tidak Valid. Format harus jpg,jpeg,png</div></div>';
                header('location: ./');
            }
            else
            {
                // Validasi tipe MIME
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
                finfo_close($finfo);
        
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        
                if (!in_array($mime, $allowedMimeTypes)) {
                    $_SESSION['msg'] = '<div class="alert alert-warning"><div class="alert-message">File Tidak Valid ! Jangan Memodifikasi File Sembarangan !</div></div>';
                    header('location: ./');
                }
                    else
                    {
                        // Membuat nama file yang aman
                        $fileName = uniqid() . '.' . $fileExtension;
                        $filePath = $uploadDir . $fileName;
        
                        // Simpan file ke direktori penyimpanan
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                            $_SESSION['msg'] = '<div class="alert alert-success"><div class="alert-message">Berhasil Upload File</div></div>';
                            unset($_SESSION['csrf_token']);
                            header('location: ./');
                        } else {
                            $_SESSION['msg'] = '<div class="alert alert-danger"><div class="alert-message">Gagal Upload File</div></div>';
                            header('location: ./');
                        }
                    }
                }
            }
        }

    

    

    
?>