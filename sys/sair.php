<?php
include 'conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

session_destroy();
header("Location: #leave");
exit;
?>

<script>
    parent.window.location = "#leave";
</script>