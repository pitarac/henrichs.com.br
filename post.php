<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Método POST é suportado.";
}
?>
<form method="post">
    <button type="submit">Testar POST</button>
</form>
