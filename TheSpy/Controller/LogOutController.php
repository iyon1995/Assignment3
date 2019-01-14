<?php
/**
 * Created by PhpStorm.
 * Author: rui.song
 * Date: 1/12/2019
 * Time: 4:25 PM
 * Version:
 * Description:
 */

require_once "../tools/CookieTools.php";
delCookie("userId");

header("Location: ../index.html");
exit();
?>