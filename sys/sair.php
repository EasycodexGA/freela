<?php
include 'conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

session_destroy();
header("Location: #leave");
exit;
?>

<script>
    localStorage.leave = "true";
</script>
