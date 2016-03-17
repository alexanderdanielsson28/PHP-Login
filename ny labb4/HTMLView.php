<?php




class HTMLView{


    public function echoHTML($htmlbody)
    {
        echo "
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset=\"utf-8\">
            </head>
            <body>
                $htmlbody
            </body>
            </html>
            ";
    }
}