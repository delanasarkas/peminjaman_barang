<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Surya Kontruksindo Utama</title>
        <link rel="shortcut icon" href="<?= base_url('/assets/img/logo_square.jpg') ?>" type="image/x-icon">
        <link href="<?= base_url('/css/styles.css') ?>" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body style="background-color: #3F4E4F">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){		
                $('#showPassword').click(function(){
                    if($(this).is(':checked')){
                        $('#password').attr('type','text');
                    }else{
                        $('#password').attr('type','password');
                    }
                });
            });
        </script>
    </body>
</html>