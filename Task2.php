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
    if ($now->format("Y") > $birthdate->format("Y") &&
        $now->format("d") == $birthdate->format("d"))
    {
        $years = $birthdate->diff($now)->y;
        $birthdate->modify("+$years years");
    }
    if ($now->format("Y") > $birthdate->format("Y"))
    {
        $years = $birthdate->diff($now)->y + 1;
        $birthdate->modify("+$years years +1 day");
    }
    elseif ($now->format("m")  >  $birthdate->format("m") &&
              $now->format("Y") === $birthdate->format("Y"))
    {
        $years = $birthdate->diff($now)->y + 1;
        $birthdate->modify("+$years years +1 day");
    }
    elseif ($now->format("d")  >  $birthdate->format("d") &&
              $now->format("m") === $birthdate->format("m") &&
              $now->format("Y") === $birthdate->format("Y"))
    {
        $years = $birthdate->diff($now)->y + 1;
        $birthdate->modify("+$years years +1 day");
    }
    else
    {
        $birthdate->modify("+1 days");
    }
    $interval = $now->diff($birthdate);
    return $interval->format('%R%a days');
}

echo birthdayCountdown('27.11.2021');