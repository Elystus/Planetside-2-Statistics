<table class="table">
    <thead>
        <tr>
            <th>Site Modules</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($modArray as $array) {
        foreach($array as $name => $path) {
            echo <<<END
<tr>
    <td>
        <a class="btn btn-primary input-block-level" href="{$path}">{$name}</a>
    </td>
</tr>
END;
        } 
    }
?>
</table>