<?php
include 'conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

session_destroy();
?>

<script>
    localStorage.leave = "true";
</script>
