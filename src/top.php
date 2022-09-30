<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="./mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Parky - <?php echo $site; ?></title>
    <script src="functions.js"></script>
</head>

<body>
    <header>
        <nav>
            <a href="/"><img alt="Logo" src="https://via.placeholder.com/200x70?text=Parky" height="70"></a>
            <ul>
                <li><?php if($site == 'home') { echo 'Home'; } else { echo "<a href='index.php'>Home</a>"; } ?></li>
                <li><?php if($site == 'cars') { echo 'Cars'; } else { echo "<a href='cars.php'>Cars</a>"; } ?></li>
            </ul>
        </nav>
    </header>
    <main>