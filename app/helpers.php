<?php

use Illuminate\Http\Request;

function flash(Request $request, $message = "", $level = 'info')
{
    $request->session()->flash('flash_message', $message);
    $request->session()->flash('flash_message_level', $level);

}

function checkString(string $process, string $material)
{
    $processSplit = explode(':', $process);
    $materialSplit = explode(':', $material);

    if ($processSplit[0] == $materialSplit[1] and $processSplit[1] == $materialSplit[2]) {
        return true;
    } else {
        return false;
    }

}

function getProcessMaterialNumber(string $process, array $materials)
{
    $count = 0;
    foreach ($materials as $material) {
        if (checkString($process, $material)) {
            $count++;
        }
    }
    $count++;
    return $count;
}

function getMaterial(string $material)
{
    $materialSplit = explode(':', $material);
    return $materialSplit[0];

}

function checkAction(string $process, string $material)
{

    $materialSplit = explode(':', $material);

    if ($process == $materialSplit[1]) {
        return true;
    } else {
        return false;
    }

}

function getActionMaterialNumber(string $process, array $materials)
{
    $count = 0;
    foreach ($materials as $material) {
        if (checkAction($process, $material)) {
            $count++;
        }
    }
    $count++;
    return $count;
}
