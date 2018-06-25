<!DOCTYPE HTML>
<html lang="fr-FR" xmlns="http://www.w3.org/1999/html">
<html>
    <header>
        <meta charset="UTF-8">
        <title>featuresDocumentor</title>
        <style>
            body {
                background-color: #ececec;
            }
            form {
                background-color: #ccffcc;
                margin: 5px 10px;
                padding: 5px 10px 10px 10px;
                border: 1px solid #666;
            }
            input {
                margin: 5px 0 0 0;
            }
        </style>
    </header>
    <body>
        <h1>featuresDocumentor</h1>
        <div>Copier / coller le chemin vers le répertoire de votre projet à analyser :</div>
        <form action="scan.php" method="post">
            <div>
                <input type="text" value="" name="path" style="width: 100%;" />
            </div>
            <div>
                <input type="checkbox" value="1" name="ignore" /> Inclure @ignore<br/>
                <input type="checkbox" value="1" name="chbx" /> avec case à cocher
            </div>
            <input type="submit" value="Envoyer" />
        </form>
    </body>
</html>