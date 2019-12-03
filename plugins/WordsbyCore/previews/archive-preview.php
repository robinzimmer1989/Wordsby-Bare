<?php wp_head(); ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview</title>

    <style>
    #wpadminbar,
    .gp-actions {
        display: none;
    }

    iframe {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    </style>
</head>

<body>
    <?php 
        $available_template = htmlspecialchars($_GET['available_template']);
        $id = htmlspecialchars($_GET['id']); 
        $query_vars = htmlspecialchars($_SERVER['QUERY_STRING']); 
        $frontend_url = get_field('build_site_url', 'option'); 
        $frontend_url_trailing_slash = rtrim($frontend_url, '/') . '/'; 
        $frontend_url_no_trailing_slash = rtrim($frontend_url, '/'); 
    ?>

    <?php if ($frontend_url): ?>
    <iframe id='preview' frameborder="0"
        src="
    <?php echo $frontend_url_trailing_slash; ?>preview/<?php echo $available_template; ?>?preview=<?php echo $_GET['id']; ?>&nonce=<?php echo $_GET['nonce']; ?>&rest_base=<?php echo $_GET['rest_base']; ?>&userId=<?php echo $_GET['userId']; ?>"></iframe>
    <?php endif; ?>
</body>

</html>
<?php wp_footer(); ?>