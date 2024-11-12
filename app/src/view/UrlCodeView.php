<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <main>
        <h1>Your shortened URL</h1>
            <div class="formurl">
                <input class="code" type="text" id="code" readonly>
                <button onclick="copy()">Copy URL</button>
            </div>
            <span id="origin_url"></span>
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
    width: 60%;
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

button {
    display: table-cell;
    width: 20%;
    box-sizing: border-box;
    vertical-align: middle;
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

span {
    display: table;
    margin: 0 auto;
}

a {
    color: #006cff;
    text-decoration: none;
}
</style>

<script>
    <?php if ((isset($code) && $code !== null) && (isset($origin_url) && $origin_url != null)): ?>
        const code = "<?php echo 'http://localhost/' . $code; ?>";
        const origin_url = "<?php echo "Origin URL: <a href='" .$origin_url. "'>" .$origin_url. "</a>"; ?>";
        
        document.getElementById("code").value = code;
        document.getElementById("origin_url").innerHTML = origin_url;

        function copy() {
            var code = document.getElementById("code");
        
            code.select();
            code.setSelectionRange(0,99999);

            navigator.clipboard.writeText(code.value);
        }
    <?php endif; ?>
</script>