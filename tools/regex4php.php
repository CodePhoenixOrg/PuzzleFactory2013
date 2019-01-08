<html>
<head>
    <title>regex4php</title>
    <script>
    function btoax(string) {
        return window.btoa(unescape(encodeURIComponent(string)));
    }

    function atobx(string) {
        return decodeURIComponent(escape(window.atob(string)));
    }

    function sendExpression() {
        document.querySelector('#bodyRegex').value = btoax(document.querySelector('#bodyRegexRaw').value);
        if(document.querySelector('#bodyRegex').value !== '') { 
            document.querySelector('#regex4php button#send').disabled = false;
            document.querySelector('#regex4php button#view').disabled = false;
        ;
        return false;
    }
    </script>

</head>
<body>
<h1>regex4php</h1>
<?php
echo print_r($_POST, true) . "<br>";

if (isset($_POST["bodyRegex"]) && !empty($_POST["bodyRegex"])) {
    $body = htmlspecialchars_decode(base64_decode($_POST["bodyRegex"])); ?>
    <p>
        <button type="submit" name="do" value="back" onclick="window.history.back();">back</button>
    </p>
<?php
} else {
        ?>
<form method="post" action="index.php" name="regex4php" id="regex4php">
    <p>
    <label for="fromRegex">Expression</label>
    <input type="text" name="fromRegex" id="fromRegex" style="width:400px;" value="/([a-z]*)_([a-z])([a-z]*)/m">
    </p>
    <p>
    <label for="toRegex">Substitution</label>
    <input type="text" name="toRegex" id="toRegex" style="width:400px;" value="\\1\\strtoupper\\2" >
    </p>
    &nbsp;&nbsp;&nbsp;
    <button type="submit" onclick="sendExpression();" name="do" id="send" value="send">search</button>
    &nbsp;&nbsp;&nbsp;
    <button type="submit" onclick="sendExpression();" name="do" id="view" value="view">replace</button>
    </p>
    <p> 
    <input type="hidden" name="bodyBase64" id="bodyBase64">
    </p>
    <p> 
    <label for="bodyRegexRaw">Corp</label>
    <textarea name="bodyRegexRaw" id="bodyRegexRaw" cols="80" rows="24"></textarea>
    </p>
</form>



<?php
    }
?>
</body>
</html>
