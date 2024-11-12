<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Url Shortener</title>
</head>
<body>

    <main>
        <h1>Paste the URL to be shortened</h1>
        <form method="post">
            <div class="formurl">
                <input type="text" name="origin_url" id="origin_url" placeholder="Enter the link here" required>
                <div class="formbtn">
                    <input type="submit" value="Shorten URL">
                </div>
            </div>
        </form>
        <span id="error"></span>
    </main>

</body>
</html>

<style>

body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80vh;
    margin: 0;
}

main {
    display: block;
    text-align: center;
    padding: 20px;
    max-width: 620px;
    width: 80%;
    background-color: #f9f9f9;
}

.formurl {
    display: flex;
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
    justify-content: center;
}

.formurl input[type="text"] {
    display: table-cell;
    width: 90%;
    height: 56px;
    padding: 10px 16px;
    font-size: 17px;
    color: #000;
    background: #fff;
    margin-bottom: 20px;
    border: 1px solid #bbb;
    border-radius: 3px;
    box-sizing: border-box;
}

.formurl input[type="text"]:hover {
    border-color: #0056b3;
}

.formurl input[type="text"]:focus {
    border-color: #00448f;
}

.formbtn {
    display: table-cell;
    width: 1%;
    box-sizing: border-box;
    vertical-align: middle;
}

.formbtn input[type="submit"] {
    height: 56px;
    padding: 8px;
    font: bold 17px lato,arial;
    color: #fff;
    background-color: #2c87c5;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    border: 0;
    border-radius: 3px;
    margin: 0;
}

#error {
    color: red;
    font-weight: bold;
    font-size: 14px;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}
</style>

<script>
    <?php if (isset($error) && $error !== null): ?>
        const errorMessage = "<?php echo $error; ?>";
        document.getElementById("error").innerHTML = errorMessage;
    <?php endif; ?>
</script>
