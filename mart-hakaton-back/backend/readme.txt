1.��� ����� ��� �����:
index.php
config.php
vk.php

2.��� ����� ������ � �������

3.��� ����� ���������������� ���������� � vk �� ������:
http://vk.com/apps?act=manage
��� ���� ��� �� �������� ID ���������� � ���������� ����
�������� ��� ���������� "����" � ����������� ��� ����� http://server.ru/vk.php


���:
//���� config.php
<?
define('ID', '8032592'); //ID ����������
define('SECRET', 'AbDarC3eDGMlyRsCnZQe'); //���������� ����
define('URL', 'http://server.ru/vk.php'); //URL ���������
?>


//���� index.php
<?
include 'config.php';
?>
<!-- https://dev.vk.com/api/access-token/authcode-flow-user -->
<a href="https://oauth.vk.com/authorize?client_id=<?=ID?>&display=page&redirect_uri=<?=URL?>&scope=photos&response_type=code&v=5.131" target="_blank">VK AUTHORIZE</a>


//���� vk.php
<?
if (!$_GET['code']){
exit('error code');
}

var_dump($_GET['code']);

include 'config.php';
//https://dev.vk.com/api/access-token/authcode-flow-community#5.%20%D0%9F%D0%BE%D0%BB%D1%83%D1%87%D0%B5%D0%BD%D0%B8%D0%B5%20access_token
$token = json_decode(file_get_contents('http://oauth.vk.com/access_token?client_id='.ID.'&client_secret='.SECRET.'&redirect_uri='.URL.'&code='.$_GET['code']), true);

if (!$token){
exit('error tokenlol');
}

echo'<pre>';
var_dump($token); //������� ���������� � �������� 
echo'</pre>';
//https://dev.vk.com/method/users.get
$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?access_token='.$token['access_token'].'&user_ids='.$token['user_id'].'&fields=first_name,last_name,photo_200_orig&name_case=nom&v=5.131'), true);

if (!$data){
exit('error data');
}

echo'<pre>';
var_dump($data); //������� ���������� � ��������
echo'</pre>';

?>