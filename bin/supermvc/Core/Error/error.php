<?php
!isset($msg) && $msg = '提示信息:';
!isset($traces) && $traces = array();
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="robots" content="noindex, nofollow, noarchive"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo $msg ?></title>
        <style>
            body {
                padding: 0;
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                background: #e6e6e6;
                color: #5E5E5E;
            }

            div, h1, h2, h3, h4, p, form, label, input, textarea, img, span {
                margin: 0;
                padding: 0;
            }

            ul {
                margin: 0;
                padding: 0;
                list-style-type: none;
                font-size: 0;
                line-height: 0;
            }

            #body {
                width: 1048px;
                margin: 0 auto;
            }

            #main {
                width: 1048px;
                margin: 13px auto 0 auto;
                padding: 0 0 35px 0;
            }

            #contents {
                width: 1048px;
                float: left;
                margin: 13px auto 0 auto;
                background: #FFF;
                padding: 8px 0 50px 9px;
            }

            #contents h2 {
                display: block;
                background: #8892BF;
                padding: 12px 0 12px 30px;
                margin: 0 10px 22px 1px;
            }

            #contents ul {
                padding: 0 0 0 18px;
                font-size: 0;
                line-height: 0;
            }

            #contents ul li {
                display: block;
                padding: 0;
                color: #8F8F8F;
                background-color: inherit;
                font: normal 14px Arial, Helvetica, sans-serif;
                margin: 0;
            }

            #contents ul li span {
                display: block;
                color: #408BAA;
                background-color: inherit;
                font: bold 14px Arial, Helvetica, sans-serif;
                padding: 0 0 10px 0;
                margin: 0;
            }

            #show {
                width: 950px;
                font: normal 14px Arial, Helvetica, sans-serif;
                border: #EBF3F5 solid 4px;
                margin: 0 30px 20px 30px;
                padding: 10px 20px;
                line-height: 23px;
            }

            #show span {
                padding: 0;
                margin: 0;
            }

            #show #current {
                font: normal 16px Arial, Helvetica, sans-serif;
                height: 40px;
                line-height: 40px;
                background: #FFFFCC;
            }
        </style>
    </head>
    <body>
    <div id="main">
        <div id="contents">
            <h2><?php echo $msg ?></h2>
            <?php
            foreach ($traces as $trace) {
                if (is_array($trace) && !empty($trace["file"])) {
                    $souceline = show_source_code($trace["file"], $trace["line"]);
                    if ($souceline) {
                        echo '<ul>
                                <li><span>'.$trace["file"].' on line '.$trace["line"].'</span></li>
                              </ul>';
                        echo '<div id="show">';
                            foreach ($souceline as $singleline){
                                echo $singleline;
                            }
                        echo '</div>';
                    }
                }
            } ?>
        </div>
    </div>
    <div style="clear:both;">
    </body>
    </html>
<?php
/*
 * show_source_code
 */
function show_source_code($file, $line)
{
    if (!(file_exists($file) && is_file($file))) {
        return '';
    }
    $data = file($file);
    $count = count($data) - 1;
    $start = $line - C('error.show_error_line_before');
    if ($start < 1) $start = 1;
    $end = $line + C('error.show_error_line_before');
    if ($end > $count)$end = $count + 1;
    $returns = array();
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $line) {
            $returns[] = "<div id='current'>" . $i . ".&nbsp;" . highlight_code($data[$i - 1], TRUE) . "</div>";
        } else {
            $returns[] = $i . ".&nbsp;" . highlight_code($data[$i - 1], TRUE).'<br>';
        }
    }
    return $returns;
}

function highlight_code($code)
{
    return str_replace('&lt;?php&nbsp;', "", highlight_string("<?php " . trim($code), TRUE));
}

?>