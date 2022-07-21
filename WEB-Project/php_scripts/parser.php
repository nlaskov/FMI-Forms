<?php
function validate_password($password)
{
    if (strlen($password) < 6) {
        return FALSE;
    }
    return TRUE;
}

function validate_confirm_password($confirm_password, $password)
{
    if ($password != $confirm_password) {
        return FALSE;
    }
    return TRUE;
}
