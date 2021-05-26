<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIDEO</title>
    <style>
    @keyframes mgm {
        from{
            max-height: 450px;

        }
        to{
            max-height: 0px;
        }
    }
    .mgm {
        width: 80px;
        border: 1px solid black;
        padding: 10px;
        animation: mgm 1s ease-in-out alternate infinite;
        max-height: 450px;
        overflow:hidden;
    }
    </style>
</head>
<body>
    <?php
    $h = file_get_contents('https://stackoverflow.com/questions/65987297/bi-directional-css-height-animation');
    echo $h;
    ?>
</iframe>
</body>
</html>