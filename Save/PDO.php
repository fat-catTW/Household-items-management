<?php
if (extension_loaded('pdo')) {
    echo "PDO is installed.<br>";
} else {
    echo "PDO is not installed.<br>";
}

if (extension_loaded('pdo_sqlsrv')) {
    echo "PDO_SQLSRV is installed.<br>";
} else {
    echo "PDO_SQLSRV is not installed.<br>";
}
phpinfo()
?>
