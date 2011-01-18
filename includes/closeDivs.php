<?php
function closeDivs($numDivs, $extraSpace = 0) {
    while ($numDivs) {
        $i = $numDivs + $extraSpace - 1;
        while ($i) {
            echo '    ';
            $i--;
            //echo $i;
        }
        echo "</div>
";
        $numDivs--;
    }
}
?>