<?php

use Helper\Flash;

if (Flash::has('success')) {
    echo "<div class='alert alert-success'>" . Flash::display('success') . "</div>";
} else if (Flash::has('error')) {
    echo "<div class='alert alert-danger'>" . Flash::display('error') . "</div>";
}
