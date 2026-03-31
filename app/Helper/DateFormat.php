<?php

function DateFormat($date)
{
    return \Carbon\Carbon::parse($date)->format('M d, Y');
}
