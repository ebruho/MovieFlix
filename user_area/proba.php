<?php

if (!is_writable('uploads')) {
    die('Directory "uploads" is not writable!');
}else{
    echo "yes";
}

 ?>