<?php
function birthdayCountdown(string $date): string
{
    $remake = str_replace('.', '-', $date);
    $now = new DateTime();
    try {
        $birthdate = new DateTime($remake);
    } catch (Exception $e) {
        echo 'Wrong date and time: ' . $e->getMessage();
        exit();
    }
    $years = $birthdate->diff($now)->y + 1;
    $birthdate->modify("+$years years");
    $interval = $now->diff($birthdate);
    return $interval->format('%R%a days');
}

echo birthdayCountdown('06.04.2000');