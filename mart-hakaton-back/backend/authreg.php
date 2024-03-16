<?php
    $id_app     = '51877729';                             //Айди приложения
    $url_script = 'https://localhost/auth_vk.php'; //ссылка на скрипт auth_vk.php
    ?>
<a href='<?php echo 'https://oauth.vk.com/authorize?client_id='.$id_app.'&redirect_uri='.$url_script.'&response_type=code'; ?>'>Войти через ВК</a></p>